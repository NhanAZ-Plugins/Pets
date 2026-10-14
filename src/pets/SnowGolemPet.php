<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class SnowGolemPet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:snow_golem"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(0.7, 1.9); }
	protected function getFollowSpeed() : float{ return 2.2; }
}
