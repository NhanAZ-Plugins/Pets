<?php

declare(strict_types=1);

namespace pets;

use pocketmine\entity\EntitySizeInfo;

final class SpiderPet extends Pets{
	public static function getNetworkTypeId() : string{ return "minecraft:spider"; }
	protected function getInitialSizeInfo() : EntitySizeInfo{ return $this->size(1.4, 0.9); }
	protected function getFollowSpeed() : float{ return 2.2; }
}
