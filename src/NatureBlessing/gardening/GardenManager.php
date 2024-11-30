<?php

namespace NatureBlessing\gardening;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\player\Player;
use NatureBlessing\Main;

class GardenManager implements Listener {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
    }

    public function onBlockPlace(BlockPlaceEvent $event): void {
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if ($block->getId() === 60) { // Farmland
            $player->sendMessage("You've planted seeds! Use fertilizer for better growth.");
        }
    }
}
