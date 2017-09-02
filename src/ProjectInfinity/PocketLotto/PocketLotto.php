<?php

namespace ProjectInfinity\PocketLotto;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\TaskHandler;
use pocketmine\utils\TextFormat;
use ProjectInfinity\PocketLotto\command\LottoCommand;
use ProjectInfinity\PocketLotto\listener\VoteListener;
use ProjectInfinity\PocketLotto\task\LottoTask;
use ProjectInfinity\PocketLotto\util\ConfigManager;
use ProjectInfinity\PocketLotto\util\LottoManager;
use ProjectInfinity\PocketLotto\util\MoneyManager;

class PocketLotto extends PluginBase {

    /** @var PocketLotto $plugin */
    private static $plugin;
    /** @var LottoManager $manager */
    private $manager;
    /** @var MoneyManager $money */
    private $money;
    /** @var TaskHandler $lottoTask */
    private $lottoTask;

    public $pocketvoteIsEnabled = false;

    public function onEnable() {
        self::$plugin = $this;

        ConfigManager::assertUpToDate();
        ConfigManager::load();

        $pocketvote = $this->getServer()->getPluginManager()->getPlugin('PocketVote');
        $this->pocketvoteIsEnabled = isset($pocketvote) ? $pocketvote->isEnabled() : false;

        $this->money = new MoneyManager($this);
        $this->manager = new LottoManager($this);

        if($this->pocketvoteIsEnabled) {
            $this->getLogger()->info(TextFormat::GREEN.'PocketVote support is enabled.');
            $this->getServer()->getPluginManager()->registerEvents(new VoteListener($this), $this);
        }

        # Plugin setup should be complete by now, it's time to start the lottery timer.
        $this->lottoTask = $this->getServer()->getScheduler()->scheduleRepeatingTask(new LottoTask($this), 20);

        $this->getServer()->getCommandMap()->register('lotto', new LottoCommand($this));
    }

    public function onDisable() {
        self::$plugin = null;
    }

    public function stopTimer() {
        if($this->lottoTask->isCancelled()) return;
        $this->lottoTask->cancel();
    }

    public static function getPlugin(): PocketLotto {
        return self::$plugin;
    }

    public function getLottoManager(): LottoManager {
        return $this->manager;
    }

    public function getMoneyManager(): MoneyManager {
        return $this->money;
    }
}