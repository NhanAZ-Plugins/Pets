<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class BatPet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:bat"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(0.9, 0.9); }
	protected function getInitialGravity() : float{ return 0.0; }
	protected function getFollowSpeed() : float{ return 2.2; }
}
