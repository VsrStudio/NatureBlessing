<?php

namespace NatureBlessing\pet;

use pocketmine\entity\Entity;
use pocketmine\entity\Location;
use pocketmine\entity\monster\Zombie;
use pocketmine\player\Player;

class Spirit extends Entity {

    public function attackNearbyMonsters(Player $player): void {
        foreach ($player->getLevel()->getEntities() as $entity) {
            if ($entity instanceof Zombie && $this->distanceSquared($entity) < 100) {
                $entity->attack(new \pocketmine\event\entity\EntityDamageEvent($entity, \pocketmine\event\entity\EntityDamageEvent::CAUSE_ENTITY_ATTACK, 5));
                $player->sendMessage("Your Spirit is fighting a monster!");
            }
        }
    }
}
