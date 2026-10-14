<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Location;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

abstract class Pets extends Entity{
	public function __construct(Location $location, protected Player $owner){
		parent::__construct($location);
	}

	public function setOwner(Player $owner) : void{
		$this->owner = $owner;
	}

	public function getOwner() : Player{
		return $this->owner;
	}

	public function canSaveWithChunk() : bool{
		return false;
	}

	protected function getInitialDragMultiplier() : float{
		return 0.02;
	}

	protected function getInitialGravity() : float{
		return 0.08;
	}

	protected function getFollowSpeed() : float{
		return 2.0;
	}

	public function onUpdate(int $currentTick) : bool{
		if(!$this->owner->isConnected()){
			$this->close();
			return false;
		}

		$ownerLocation = $this->owner->getLocation();
		$dx = $ownerLocation->x - $this->getLocation()->x;
		$dy = $ownerLocation->y - $this->getLocation()->y;
		$dz = $ownerLocation->z - $this->getLocation()->z;
		$horizontalDistanceSquared = $dx * $dx + $dz * $dz;
		$distanceSquared = $horizontalDistanceSquared + $dy * $dy;

		if($ownerLocation->getWorld() !== $this->getWorld() || $distanceSquared > 1600 || ($this->isCollidedHorizontally && $horizontalDistanceSquared > 9)){
			$this->teleportBesideOwner($ownerLocation);
		}else{
			$motionY = $this->getMotion()->y;
			if($dy > 1.0 && $this->onGround){
				$motionY = 0.42;
			}

			if($horizontalDistanceSquared <= 4){
				$this->setMotion(new Vector3(0, $motionY, 0));
			}else{
				$horizontalDistance = sqrt($horizontalDistanceSquared);
				$speed = $this->getFollowSpeed() * 0.15;
				$this->setMotion(new Vector3($dx / $horizontalDistance * $speed, $motionY, $dz / $horizontalDistance * $speed));
			}
		}

		$updated = parent::onUpdate($currentTick);
		return $updated || !$this->isClosed();
	}

	private function teleportBesideOwner(Location $ownerLocation) : void{
		$yaw = deg2rad($ownerLocation->yaw);
		$position = new Location(
			$ownerLocation->x - sin($yaw) * 1.5,
			$ownerLocation->y,
			$ownerLocation->z + cos($yaw) * 1.5,
			$ownerLocation->getWorld(),
			$ownerLocation->yaw,
			$ownerLocation->pitch
		);
		$this->teleport($position);
	}

	protected function size(float $width, float $height) : EntitySizeInfo{
		return new EntitySizeInfo($height, $width);
	}
}
