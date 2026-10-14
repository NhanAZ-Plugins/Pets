<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class IronGolemPet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:iron_golem"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(1.4, 2.7); }
	protected function getFollowSpeed() : float{ return 2.2; }
}
