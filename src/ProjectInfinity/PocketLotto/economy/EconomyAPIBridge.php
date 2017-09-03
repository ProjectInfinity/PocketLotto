<?php

namespace ProjectInfinity\PocketLotto\economy;

use onebone\economyapi\EconomyAPI;
use ProjectInfinity\PocketLotto\PocketLotto;

class EconomyAPIBridge implements EconomyPlugin {

    private $economy;

    public function __construct(PocketLotto $plugin) {
        /** @var EconomyAPI $plugin */
        $plugin = $plugin->getServer()->getPluginManager()->getPlugin('EconomyAPI');
        $this->economy = $plugin;
    }

    public function getName(): string {
        return 'EconomyAPI';
    }

    public function takeMoney(string $player, $amount): bool {
        return $this->economy->reduceMoney($player, $amount) === 1;
    }

    public function giveMoney(string $player, $amount): bool {
        return $this->economy->addMoney($player, $amount) === 1;
    }

    public function hasMoney(string $player, $amount): bool {
        return $this->economy->myMoney($player) >= $amount;
    }
}