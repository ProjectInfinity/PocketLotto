<?php

namespace ProjectInfinity\PocketLotto\util;

use ProjectInfinity\PocketLotto\economy\Economy2Bridge;
use ProjectInfinity\PocketLotto\economy\EconomyAPIBridge;
use ProjectInfinity\PocketLotto\economy\EconomyPlugin;
use ProjectInfinity\PocketLotto\PocketLotto;

class MoneyManager {

    private $plugin;
    /** @var EconomyPlugin $bridge */
    private $bridge;

    public function __construct(PocketLotto $plugin) {
        $this->plugin = $plugin;
        if($plugin->getServer()->getPluginManager()->getPlugin('EconomyAPI') !== null) $this->bridge = new EconomyAPIBridge($plugin);
        if($plugin->getServer()->getPluginManager()->getPlugin('Economy2') !== null) $this->bridge = new Economy2Bridge($plugin);
    }

    public function canAfford(string $player, $amount): bool {
        return $this->bridge->hasMoney($player, $amount);
    }

    public function pay(string $player, $amount): bool {
        return $this->bridge->takeMoney($player, $amount);
    }

    public function refund(string $player, $amount): bool {
        return $this->bridge->giveMoney($player, $amount);
    }
}