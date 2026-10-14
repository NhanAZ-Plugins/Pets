<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class OcelotPet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:cat"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(0.6, 0.7); }
}
