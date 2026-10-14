<?php

declare(strict_types=1);

$autoload = $argv[1] ?? null;
if(!is_string($autoload) || $autoload === ""){
	throw new RuntimeException("Pass the verified Axolotl-PM autoloader path as the first argument");
}
require $autoload;
require __DIR__ . "/../src/pets/Pets.php";

$expectedTypes = [
	"BatPet" => ["BatPet.php", "minecraft:bat"],
	"ChickenPet" => ["ChickenPet.php", "minecraft:chicken"],
	"IronGolemPet" => ["IronGolemPet.php", "minecraft:iron_golem"],
	"OcelotPet" => ["OcelotPet.php", "minecraft:cat"],
	"PigPet" => ["PigPet.php", "minecraft:pig"],
	"RabbitPet" => ["RabbitPet.php", "minecraft:rabbit"],
	"SnowGolemPet" => ["SnowGolemPet.php", "minecraft:snow_golem"],
	"SpiderPet" => ["SpiderPet.php", "minecraft:spider"],
	"WolfPet" => ["WolfPet.php", "minecraft:wolf"],
	"ZombiePet" => ["ZombiePet.php", "minecraft:zombie"]
];

foreach($expectedTypes as $class => [$file, $networkType]){
	require_once __DIR__ . "/../src/pets/" . $file;
	$qualifiedClass = "pets\\" . $class;
	if(!is_a($qualifiedClass, pocketmine\entity\Entity::class, true) || $qualifiedClass::getNetworkTypeId() !== $networkType){
		throw new RuntimeException("Invalid Axolotl-PM entity mapping for {$class}");
	}
}

echo "Verified " . count($expectedTypes) . " Axolotl-PM entity type mappings\n";
