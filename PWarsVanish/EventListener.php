<?php

namespace RustlingBrick86\PWarsVanish;

use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;

use function array_search;
use function in_array;

class EventListener implements Listener {

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $name = $player->getName();
        if(in_array($name, PWarsVanish::$vanish)){
            unset(PWarsVanish::$vanish[array_search($name, PWarsVanish::$vanish)]);
        }
    }
    public function PickUp(InventoryPickupItemEvent $event){
        foreach (Server::getInstance()->getOnlinePlayers() as $p) {
            $name = $p->getName();
            if (in_array($name, PWarsVanish::$vanish)) {
                $event->setCancelled();
            }
        }
    }
}
