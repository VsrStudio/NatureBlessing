<?php

namespace NatureBlessing\gardening;

use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;

class Fertilizer {

    public static function create(): \pocketmine\item\Item {
        $fertilizer = ItemFactory::getInstance()->get(ItemIds::DYE, 15); // Bone Meal
        $fertilizer->setCustomName("Fertilizer");
        return $fertilizer;
    }
}
