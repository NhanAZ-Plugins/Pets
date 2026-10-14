<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class ChickenPet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:chicken"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(0.4, 0.7); }
}
