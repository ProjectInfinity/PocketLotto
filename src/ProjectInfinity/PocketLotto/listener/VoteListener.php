<?php

namespace ProjectInfinity\PocketLotto\listener;

use pocketmine\event\Listener;
use ProjectInfinity\PocketLotto\PocketLotto;
use ProjectInfinity\PocketLotto\util\ConfigManager;
use ProjectInfinity\PocketVote\event\VoteEvent;

class VoteListener implements Listener {

    private $plugin, $lm;

    public function __construct(PocketLotto $plugin) {
        $this->plugin = $plugin;
        $this->lm = $plugin->getLottoManager();
    }

    /**
     * @priority MONITOR
     * @param VoteEvent $event
     */
    public function onVoteRetrieved(VoteEvent $event): void {
        if(\strlen($event->getPlayer()) > 16) return;
        if($this->lm->canAcquireMore($event->getPlayer()) &&
            $this->plugin->getServer()->getPlayer($event->getPlayer()) === null &&
            $this->plugin->getServer()->getOfflinePlayer($event->getPlayer()) === null) return;
        $this->lm->addTicket($event->getPlayer(), ConfigManager::getAddOnVote(), true);
    }

}