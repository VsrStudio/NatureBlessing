<?php

namespace NatureBlessing;

use pocketmine\plugin\PluginBase;
use NatureBlessing\weather\WeatherManager;
use NatureBlessing\gardening\GardenManager;
use NatureBlessing\pet\PetManager;

class Main extends PluginBase {

    private WeatherManager $weatherManager;
    private GardenManager $gardenManager;
    private PetManager $petManager;

    protected function onEnable(): void {
        $this->saveResource("config.yml");
        $this->saveResource("lang/en.yml");
        $this->saveResource("lang/id.yml");

        $this->weatherManager = new WeatherManager($this);
        $this->gardenManager = new GardenManager($this);
        $this->petManager = new PetManager($this);

        $this->getLogger()->info("NatureBlessing has been enabled!");
    }

    protected function onDisable(): void {
        $this->getLogger()->info("NatureBlessing has been disabled!");
    }

    public function getWeatherManager(): WeatherManager {
        return $this->weatherManager;
    }

    public function getGardenManager(): GardenManager {
        return $this->gardenManager;
    }

    public function getPetManager(): PetManager {
        return $this->petManager;
    }
}
