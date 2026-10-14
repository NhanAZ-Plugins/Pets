<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class ZombiePet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:zombie"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(0.6, 1.95); }
}
