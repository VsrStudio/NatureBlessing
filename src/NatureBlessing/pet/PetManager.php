<?php

namespace NatureBlessing\pet;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat as TF;
use NatureBlessing\Main;

class PetManager {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function summonSpirit(Player $player): void {
        $player->sendMessage(TF::GREEN . "A nature spirit has been summoned to protect you!");
    }
}
