# PocketLotto

A lottery plugin for PocketMine with support for PocketVote, Economy2 and EconomyAPI!


Features
--------

* Customizable time per draw.
* Set minimum players participating for a draw to go through.
* Customizable prize pool and ticket prices (the latter gets added to the pool as a player purchases a ticket).
* Limit maximum amount of tickets possible to purchase per player.
* Give tickets to player as a reward for voting with PocketVote support.


Usage
-----
| Command | Description | Permission
| --- | --- | --- |
| /lotto buy [amount] | Attempts to buy the specified [amount] of tickets. This will be limited to whatever the server operator sets as the max tickets per player. | pocketlotto.user
| /lotto time | Shows the remaining time until the next draw. | pocketlotto.user
