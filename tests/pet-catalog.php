<?php

declare(strict_types=1);

require __DIR__ . "/../src/pets/PetCatalog.php";

use pets\PetCatalog;

$legacyTypes = [
	"BatPet" => "BatPet",
	"ChickenPet" => "ChickenPet",
	"IronGolemPet" => "IronGolemPet",
	"OcelotPet" => "OcelotPet",
	"PigPet" => "PigPet",
	"RabbitPet" => "RabbitPet",
	"SnowGolemPet" => "SnowGolemPet",
	"SpiderPet" => "SpiderPet",
	"WolfPet" => "WolfPet",
	"ZombiePet" => "ZombiePet"
];

foreach($legacyTypes as $legacyType => $expected){
	if(PetCatalog::resolve($legacyType) !== $expected){
		throw new RuntimeException("Legacy type {$legacyType} did not retain its mapping");
	}
}

if(PetCatalog::resolve("not-a-pet") !== null || count(PetCatalog::commandTypes()) !== 11){
	throw new RuntimeException("Unknown pet types must be rejected and command types must stay bounded");
}

echo "Passed legacy pet type migration cases\n";
