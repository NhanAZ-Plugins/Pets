<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class PigPet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:pig"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(0.9, 0.9); }
	protected function getFollowSpeed() : float{ return 2.1; }
}
