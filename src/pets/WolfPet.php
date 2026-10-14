<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class WolfPet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:wolf"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(0.6, 0.85); }
	protected function getFollowSpeed() : float{ return 2.2; }
}
