<?php

namespace ProjectInfinity\PocketLotto\economy;

 use ProjectInfinity\Economy2\Economy2;
 use ProjectInfinity\PocketLotto\PocketLotto;

 class Economy2Bridge implements EconomyPlugin {

     private $economy;

     public function __construct(PocketLotto $plugin) {
         /** @var Economy2 $plugin */
         $plugin = $plugin->getServer()->getPluginManager()->getPlugin('Economy2');
         $this->economy = $plugin->getMoneyHandler();
     }

     public function getName(): string {
        return 'Economy2';
     }

     public function takeMoney(string $player, $amount): bool {
         $amount = (float) $amount;
         return $this->economy->alterBalance($player, -$amount);
     }

     public function giveMoney(string $player, $amount): bool {
         return $this->economy->alterBalance($player, $amount);
     }

     public function hasMoney(string $player, $amount): bool {
         return $this->economy->getBalance($player) >= $amount;
     }
 }