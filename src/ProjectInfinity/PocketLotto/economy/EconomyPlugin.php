<?php

namespace ProjectInfinity\PocketLotto\economy;

interface EconomyPlugin {
    public function getName(): string;
    public function takeMoney(string $player, $amount): bool;
    public function giveMoney(string $player, $amount): bool;
    public function hasMoney(string $player, $amount): bool;
}