<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class RabbitPet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:rabbit"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(0.4, 0.5); }
}
