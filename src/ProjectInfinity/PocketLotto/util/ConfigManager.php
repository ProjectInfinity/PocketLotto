<?php
namespace ProjectInfinity\PocketLotto\util;

use ProjectInfinity\PocketLotto\PocketLotto;

class ConfigManager {

    private static $drawTimer, $price, $maxTickets, $allowPurchase, $addOnVote, $configVersion, $startPool, $currencyName, $minPlayers;

    public static function load() {
        $plugin = PocketLotto::getPlugin();
        $plugin->saveDefaultConfig();

        $config = PocketLotto::getPlugin()->getConfig();
        # Load configuration values.
        self::$configVersion = $config->get('version', 1);
        self::$drawTimer = $config->get('draw-timer-seconds', 3600);
        self::$price = $config->getNested('ticket.price', 5);
        self::$maxTickets = $config->getNested('ticket.max-tickets', 10);
        self::$allowPurchase = $config->getNested('ticket.allow-purchase', true);
        self::$addOnVote = $config->getNested('ticket.add-tickets-on-vote', 1);
        self::$startPool = $config->getNested('ticket.start-pool', 50);
        self::$currencyName = $config->getNested('currency-name', 'Dollars');
        self::$minPlayers = $config->getNested('ticket.min-players', 2);
    }

    public static function assertUpToDate() {
        # This is more of a placeholder until a new version comes out.
        #$this->checkV1();
    }

    public static function getDrawTimer(): int {
        return self::$drawTimer > 9 ? self::$drawTimer : 10;
    }

    public static function getPrice() {
        return self::$price;
    }

    public static function getMaxTickets() {
        return self::$maxTickets;
    }

    public static function getAllowPurchase() {
        return self::$allowPurchase;
    }

    public static function getAddOnVote() {
        return self::$addOnVote;
    }

    public static function getStartPool(): int {
        return self::$startPool;
    }

    public static function getCurrencyName(): String {
        return self::$currencyName;
    }

    public static function getMinimumPlayers(): int {
        return self::$minPlayers;
    }

    private function checkV1() {}
}