<?php

namespace NatureBlessing\gardening;

use NatureBlessing\Main;
use pocketmine\block\Block;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

class GardenManager {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function applyFruitToTrees(): void {
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
}
