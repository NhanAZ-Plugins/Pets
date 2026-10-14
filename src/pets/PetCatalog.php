<?php

declare(strict_types=1);

namespace pets;

final class PetCatalog{
	/** @var array<string, string> */
	private const TYPES = [
		"bat" => "BatPet",
		"batpet" => "BatPet",
		"cat" => "OcelotPet",
		"chicken" => "ChickenPet",
		"chickenpet" => "ChickenPet",
		"dog" => "WolfPet",
		"irongolem" => "IronGolemPet",
		"irongolempet" => "IronGolemPet",
		"ocelotpet" => "OcelotPet",
		"pig" => "PigPet",
		"pigpet" => "PigPet",
		"rabbit" => "RabbitPet",
		"rabbitpet" => "RabbitPet",
		"snowgolem" => "SnowGolemPet",
		"snowgolempet" => "SnowGolemPet",
		"spider" => "SpiderPet",
		"spiderpet" => "SpiderPet",
		"wolf" => "WolfPet",
		"wolfpet" => "WolfPet",
		"zombie" => "ZombiePet",
		"zombiepet" => "ZombiePet"
	];

	public static function resolve(string $type) : ?string{
		return self::TYPES[strtolower($type)] ?? null;
	}

	/** @return list<string> */
	public static function commandTypes() : array{
		return ["bat", "cat", "chicken", "dog", "irongolem", "pig", "rabbit", "snowgolem", "spider", "wolf", "zombie"];
	}
}
