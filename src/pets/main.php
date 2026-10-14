<?php

declare(strict_types=1);

namespace pets;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Location;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

final class main extends PluginBase implements Listener{
	/** @var array<string, Pets> */
	private array $activePets = [];
	private string $playerDirectory;

	protected function onEnable() : void{
		$this->playerDirectory = rtrim($this->getDataFolder(), "\\/") . DIRECTORY_SEPARATOR . "players" . DIRECTORY_SEPARATOR;
		if(!is_dir($this->playerDirectory) && !mkdir($this->playerDirectory, 0777, true) && !is_dir($this->playerDirectory)){
			throw new \RuntimeException("Unable to create the Pets player-data directory");
		}
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	protected function onDisable() : void{
		foreach($this->activePets as $pet){
			$pet->close();
		}
		$this->activePets = [];
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if(strtolower($command->getName()) !== "pets"){
			return false;
		}
		if(!$sender instanceof Player){
			$sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
			return true;
		}

		$subcommand = strtolower($args[0] ?? "help");
		switch($subcommand){
			case "type":
			case "เลือก":
				$type = $args[1] ?? "";
				if(!$this->changePet($sender, $type)){
					$sender->sendMessage(TextFormat::RED . "Invalid pet type. Choose: " . implode(", ", PetCatalog::commandTypes()));
					return true;
				}
			$sender->sendMessage(TextFormat::GREEN . "Your " . strtolower(PetCatalog::resolve($type) ?? "pet") . " companion has been summoned.");
			return true;
			case "off":
			case "ปิด":
				$this->disablePet($sender, true);
				$sender->sendMessage(TextFormat::GREEN . "Your pet has been dismissed.");
				return true;
			case "name":
			case "setname":
			case "ตั้งชื่อ":
				$this->renamePet($sender, array_values(array_slice($args, 1)));
				return true;
			case "info":
			case "ข้อมูล":
				$sender->sendMessage(TextFormat::AQUA . "Pets companion plugin, originally created by NameLess and edited/translated by Ghast Noob.");
				return true;
			case "size":
			case "ขนาด":
				$sender->sendMessage(TextFormat::RED . "Pet size changes are not implemented.");
				return true;
			case "help":
			case "ช่วยเหลือ":
			default:
				$sender->sendMessage(TextFormat::YELLOW . "Use /pets type <" . implode("|", PetCatalog::commandTypes()) . ">, /pets name <name>, or /pets off.");
				$sender->sendMessage(TextFormat::GRAY . "Use /pets info for credits. Pet size changes are not implemented.");
				return true;
		}
	}

	public function changePet(Player $player, string $requestedType) : bool{
		$type = PetCatalog::resolve($requestedType);
		if($type === null){
			return false;
		}

		$this->disablePet($player);
		$pet = $this->createPet($player, $type);
		$this->activePets[$player->getUniqueId()->toString()] = $pet;
		$pet->spawnToAll();

		$data = $this->playerConfig($player);
		$data->set("type", $type);
		$savedName = $data->get("name");
		if(is_string($savedName) && $savedName !== ""){
			$pet->setNameTag($savedName);
		}
		$data->save();
		return true;
	}

	public function disablePet(Player $player, bool $clearSavedSelection = false) : void{
		$key = $player->getUniqueId()->toString();
		if(isset($this->activePets[$key])){
			$this->activePets[$key]->close();
			unset($this->activePets[$key]);
		}

		if($clearSavedSelection){
			$data = $this->playerConfig($player);
			$data->remove("type");
			$data->remove("name");
			$data->save();
		}
	}

	public function getPet(Player $player) : ?Pets{
		return $this->activePets[$player->getUniqueId()->toString()] ?? null;
	}

	public function onPlayerQuit(PlayerQuitEvent $event) : void{
		$this->disablePet($event->getPlayer());
	}

	public function onPlayerJoin(PlayerJoinEvent $event) : void{
		$player = $event->getPlayer();
		$data = $this->playerConfig($player);
		$type = $data->get("type");
		if(!is_string($type) || !$this->changePet($player, $type)){
			return;
		}
		$name = $data->get("name");
		if(is_string($name) && $name !== ""){
			$this->getPet($player)?->setNameTag($name);
		}
	}

	private function createPet(Player $player, string $type) : Pets{
		$location = $player->getLocation();
		$yaw = deg2rad($location->yaw);
		$spawnLocation = new Location(
			$location->x - sin($yaw) * 2,
			$location->y,
			$location->z + cos($yaw) * 2,
			$location->getWorld(),
			$location->yaw,
			$location->pitch
		);

		$pet = match($type){
			"BatPet" => new BatPet($spawnLocation, $player),
			"ChickenPet" => new ChickenPet($spawnLocation, $player),
			"IronGolemPet" => new IronGolemPet($spawnLocation, $player),
			"OcelotPet" => new OcelotPet($spawnLocation, $player),
			"PigPet" => new PigPet($spawnLocation, $player),
			"RabbitPet" => new RabbitPet($spawnLocation, $player),
			"SnowGolemPet" => new SnowGolemPet($spawnLocation, $player),
			"SpiderPet" => new SpiderPet($spawnLocation, $player),
			"WolfPet" => new WolfPet($spawnLocation, $player),
			"ZombiePet" => new ZombiePet($spawnLocation, $player),
			default => throw new \LogicException("Unsupported canonical pet type: {$type}")
		};
		$pet->setNameTag($player->getName() . "'s Pet");
		$pet->setNameTagVisible(true);
		$pet->setNameTagAlwaysVisible(true);
		return $pet;
	}

	/** @param list<string> $nameParts */
	private function renamePet(Player $player, array $nameParts) : void{
		$name = trim(implode(" ", $nameParts));
		$pet = $this->getPet($player);
		if($pet === null){
			$player->sendMessage(TextFormat::RED . "Summon a pet before naming it.");
			return;
		}
		if($name === "" || strlen($name) > 64){
			$player->sendMessage(TextFormat::RED . "Pet names must contain 1 to 64 bytes.");
			return;
		}

		$pet->setNameTag($name);
		$pet->setNameTagVisible(true);
		$pet->setNameTagAlwaysVisible(true);
		$data = $this->playerConfig($player);
		$data->set("name", $name);
		$data->save();
		$player->sendMessage(TextFormat::GREEN . "Your pet is now named " . $name . ".");
	}

	private function playerConfig(Player $player) : Config{
		$name = strtolower($player->getName());
		$reservedWindowsNames = ["con", "prn", "aux", "nul", "com1", "com2", "com3", "com4", "com5", "com6", "com7", "com8", "com9", "lpt1", "lpt2", "lpt3", "lpt4", "lpt5", "lpt6", "lpt7", "lpt8", "lpt9"];
		if(preg_match('/^[a-z0-9_][a-z0-9 _-]{0,62}[a-z0-9_]$/D', $name) !== 1 || in_array($name, $reservedWindowsNames, true)){
			$name = $player->getUniqueId()->toString();
		}
		return new Config($this->playerDirectory . $name . ".yml", Config::YAML);
	}
}
