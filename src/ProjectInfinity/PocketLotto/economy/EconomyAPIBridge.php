<?php

namespace ProjectInfinity\PocketLotto\economy;

class EconomyAPIBridge implements EconomyPlugin {

    public function getName(): string {
        return 'EconomyAPI';
    }

    public function takeMoney(string $player, $amount): bool {
        // TODO: Implement takeMoney() method.
    }

    public function giveMoney(string $player, $amount): bool {
        // TODO: Implement giveMoney() method.
    }

    public function hasMoney(string $player, $amount): bool {
        // TODO: Implement hasMoney() method.
    }
}