<?php

namespace NatureBlessing\weather;

use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use NatureBlessing\Main;

class WeatherManager {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $plugin->getScheduler()->scheduleRepeatingTask(new class($this) extends Task {
            private WeatherManager $manager;

            public function __construct(WeatherManager $manager) {
                $this->manager = $manager;
            }

            public function onRun(): void {
                $this->manager->applyWeatherEffects();
            }
        }, 20 * 60); // 1-minute interval
    }

    public function applyWeatherEffects(): void {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $weather = $this->getWeatherCondition();
            switch ($weather) {
                case "rain":
                    $player->sendMessage("The rain soothes you, restoring some health.");
                    $player->setHealth(min($player->getMaxHealth(), $player->getHealth() + 1));
                    break;

                case "storm":
                    $player->sendMessage("A storm is brewing! Be careful.");
                    break;

                case "sunny":
                    $player->sendMessage("The sunny weather makes you feel energized!");
                    break;
            }
        }
    }

    private function getWeatherCondition(): string {
        $conditions = ["rain", "storm", "sunny"];
        return $conditions[array_rand($conditions)];
    }
}
