<?php

namespace RustlingBrick86\PWarsVanish;

use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\network\mcpe\protocol\types\PlayerListEntry;
use pocketmine\network\mcpe\protocol\types\SkinData;
use pocketmine\network\mcpe\protocol\types\SkinAdapterSingleton;
use pocketmine\scheduler\Task;
use pocketmine\Server;

use function in_array;

class PWarsVanishTask extends Task {
    public $pk;

    public function onRun(int $currentTick){
        foreach(Server::getInstance()->getOnlinePlayers() as $p){
            if($p->spawned){
                if(in_array($p->getName(), PWarsVansh::$vanish)){
                    foreach(Server::getInstance()->getOnlinePlayers() as $player){
                        $p->sendPopup("§f[§6PWarsVanish§f] §aYou are currently Vanished!");
			            if($player->hasPermission("pwarsvanish.see")){
			                $player->showPlayer($p);
		                }else{
			                $player->hidePlayer($p);
			                $entry = new PlayerListEntry();
			                $entry->uuid = $p->getUniqueId();

			                $pk = new PlayerListPacket();
			                $pk->entries[] = $entry;
			                $pk->type = PlayerListPacket::TYPE_REMOVE;
			                $player->sendDataPacket($pk);
		                }
                    }
                }
            }
        }
    }
}
