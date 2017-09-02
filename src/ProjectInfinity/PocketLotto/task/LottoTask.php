<?php
namespace ProjectInfinity\PocketLotto\task;

use DateTime;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;
use ProjectInfinity\PocketLotto\PocketLotto;
use ProjectInfinity\PocketLotto\util\ConfigManager;

class LottoTask extends Task {

    /** @var PocketLotto $plugin */
    private $plugin, $lm, $drawTimer;
    /** @var DateTime $nextTime */
    private $nextTime;

    public function __construct(PocketLotto $plugin) {
        $this->plugin = $plugin;
        $this->lm = $plugin->getLottoManager();
        $this->drawTimer = $this->lm->getDrawTimer();

        #$this->prevTime = $this->nextTime;
        $this->lm->setNextDraw();
    }

    public function onRun(int $currentTick) {
        #$this->plugin->getLogger()->debug('LottoTask ran.');
        $remaining = $this->lm->getTimeRemaining();
        if(empty($remaining)) $remaining = 'A couple of seconds';

        $diff = $this->lm->getNextDraw()->diff(new DateTime('now'));

        # Check if it is time to draw.
        if($diff->h === 0 && $diff->i === 0 && $diff->s === 0) {
            $this->draw();
        } else {
            # It wasn't time to draw, figure out if it's time to send a message.
        }
        # TODO: Create intervals for when a message should be sent.

        #$this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW.'[PocketLotto] '.trim($remaining).' remaining until next draw.');
        #$this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW.'[PocketLotto] Current prize pool: '.$this->lm->getPrizePool().' '.ConfigManager::getCurrencyName().'!');
    }

    private function renew() {
        $this->lm->setNextDraw();
        $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW.'[PocketLotto] Next draw in '.trim($this->timeRemaining()).'.');
    }

    /**
     * Perform a draw and reward the player who won.
     */
    private function draw() {
        if($this->lm->countPlayers() < ConfigManager::getMinimumPlayers()) {
            $this->lm->refundAll();
            $this->plugin->getServer()->broadcastMessage(TextFormat::YELLOW.'[PocketLotto] There was not enough players participating. Tickets have been refunded.');
            return;
        }
        # TODO: Continue draw.
        # Finished drawing, now it's time to renew.
        $this->renew();
    }
}