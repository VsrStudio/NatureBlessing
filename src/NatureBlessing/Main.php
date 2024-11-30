<?php

namespace NatureBlessing;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class Main extends PluginBase {

    protected function onEnable(): void {
        $this->getServer()->getCommandMap()->register("natureblessing", new NatureBlessingCommand($this));
    }

    public function getWeatherManager(): WeatherManager {
        return new WeatherManager($this);
    }

    public function getGardenManager(): GardenManager {
        return new GardenManager($this);
    }

    public function getPetManager(): PetManager {
        return new PetManager($this);
    }
}

class NatureBlessingCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("nbweather", "Manage weather effects", "/nbweather <rain|storm|sunny>", []);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used by players.");
            return;
        }

        if (empty($args)) {
            $sender->sendMessage("Please specify a weather type (rain, storm, sunny).");
            return;
        }

        $weather = strtolower($args[0]);

        if ($weather === "rain" || $weather === "storm" || $weather === "sunny") {
            $this->plugin->getWeatherManager()->applyWeatherEffects();
            $sender->sendMessage("Weather has been changed to $weather.");
        } else {
            $sender->sendMessage("Invalid weather type.");
        }
    }
}
