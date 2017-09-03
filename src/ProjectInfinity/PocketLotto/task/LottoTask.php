<?php
namespace ProjectInfinity\PocketLotto\task;

use DateTime;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;
use ProjectInfinity\PocketLotto\PocketLotto;
use ProjectInfinity\PocketLotto\util\ConfigManager;

class LottoTask extends Task {

    /** @var PocketLotto $plugin */
    private $plugin, $lm;

    public function __construct(PocketLotto $plugin) {
        $this->plugin = $plugin;
        $this->lm = $plugin->getLottoManager();
        $this->lm->setNextDraw();
    }

    public function onRun(int $currentTick) {
        $remaining = trim($this->lm->getTimeRemaining());
        if(empty($remaining)) $remaining = 'A couple of seconds';

        $diff = $this->lm->getNextDraw()->diff(new DateTime('now'));

        # Check if it is time to draw.
        if($diff->h === 0 && $diff->i === 0 && $diff->s === 0) {
            $this->draw();
        } else {
            # It wasn't time to draw, figure out if it's time to send a message.
            if($diff->i === 45 && $diff->s === 0) {
                # 45 Minutes remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
            if($diff->i === 30 && $diff->s === 0) {
                # 30 Minutes remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                    TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
            if($diff->i === 15 && $diff->s === 0) {
                # 15 Minutes remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                    TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
            if($diff->i === 10 && $diff->s === 0) {
                # 10 Minutes remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                    TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
            if($diff->i === 5 && $diff->s === 0) {
                # 5 Minutes remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                    TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
            if($diff->i === 2 && $diff->s === 0) {
                # 2 Minutes remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                    TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
            if($diff->i === 1 && $diff->s === 0) {
                # 1 Minutes remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                    TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
            if($diff->i === 0 && $diff->s === 30) {
                # 30 seconds remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                    TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
            if($diff->i === 0 && $diff->s === 10) {
                # 10 seconds remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                    TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
            if($diff->i === 0 && $diff->s <= 5) {
                # Less than 5 seconds remaining.
                $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW."[PocketLotto] $remaining until draw! Current prize pool is ".
                    TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());
            }
        }
    }

    /**
     * Perform a draw and reward the player who won.
     */
    private function draw() {
        if($this->lm->countPlayers() < ConfigManager::getMinimumPlayers()) {
            $this->lm->refundAll();
            $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW.'[PocketLotto] There was not enough players participating. Tickets have been refunded.');
            $this->lm->setNextDraw();
            return;
        }
        $tickets = [];
        foreach($this->lm->getPlayers() as $player => $amount) {
            for($i = 0; $i < $amount; $i++) {
                $tickets[] = $player;
            }
        }
        shuffle($tickets);
        $player = $tickets[array_rand($tickets)];

        $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW.'[PocketLotto] '.
            TextFormat::GREEN.$player.TextFormat::YELLOW.' won '.TextFormat::GREEN.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName());

        $this->lm->getMoneyManager()->give($player, $this->lm->getPrizePool());

        # Finished drawing, now it's time to renew.
        $this->lm->setNextDraw();
        $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW.'[PocketLotto] Next draw in '.trim($this->lm->getTimeRemaining()).'.');
    }
}