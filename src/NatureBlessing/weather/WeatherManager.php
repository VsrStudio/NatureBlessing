<?php

namespace NatureBlessing\weather;

use NatureBlessing\Main;
use pocketmine\player\Player;
use pocketmine\block\Block;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

class WeatherManager {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function applyWeatherEffects(): void {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $weather = $this->getWeatherCondition();
            switch ($weather) {
                case "rain":
                    $player->sendMessage("The rain soothes you, restoring some health.");
                    $player->setHealth(min($player->getMaxHealth(), $player->getHealth() + 1));
                    $this->affectMonstersWithRain();
                    $this->applyFruitToTrees();
                    break;

                case "storm":
                    $player->sendMessage("A storm is brewing! Be careful.");
                    $this->affectMonstersWithStorm();
                    $this->affectPlantsWithStorm();
                    break;

                case "sunny":
                    $player->sendMessage("The sunny weather makes you feel energized!");
                    break;
            }
        }
    }

    private function affectMonstersWithRain(): void {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            foreach ($player->getLevel()->getEntities() as $entity) {
                if ($entity instanceof \pocketmine\entity\Monster) {
                    $entity->setHealth($entity->getMaxHealth());
                }
            }
        }
    }

    private function affectMonstersWithStorm(): void {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            foreach ($player->getLevel()->getEntities() as $entity) {
                if ($entity instanceof \pocketmine\entity\Monster) {
                    $entity->setDamage(20);
                }
            }
        }
    }

    private function applyFruitToTrees(): void {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $radius = 5;
            $center = $player->getPosition();
            
            for ($x = -$radius; $x <= $radius; $x++) {
                for ($y = -1; $y <= 1; $y++) {
                    for ($z = -$radius; $z <= $radius; $z++) {
                        $block = $center->add($x, $y, $z)->getLevel()->getBlockAt($center->getFloorX() + $x, $center->getFloorY() + $y, $center->getFloorZ() + $z);
                        if ($block->getId() === Block::LOG) {
                            $player->getInventory()->addItem(ItemFactory::getInstance()->get(ItemIds::APPLE, 0, 1));
                            $player->sendMessage(TextFormat::GREEN . "A tree nearby has borne fruit!");
                        }
                    }
                }
            }
        }
    }

    private function affectPlantsWithStorm(): void {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            foreach ($player->getLevel()->getEntities() as $entity) {
                if ($entity instanceof \pocketmine\block\Block && ($entity->getId() === Block::CROPS || $entity->getId() === Block::LOG)) {
                    $entity->setBlockId(Block::AIR);
                    $player->sendMessage(TextFormat::RED . "A storm has destroyed your crops!");
                }
            }
        }
    }

    private function getWeatherCondition(): string {
        // For simplicity, we return a random weather condition.
        $weatherTypes = ["rain", "storm", "sunny"];
        return $weatherTypes[array_rand($weatherTypes)];
    }
}
