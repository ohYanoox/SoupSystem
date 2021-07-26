<?php

namespace Yanoox;

use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class soupSystem extends PluginBase implements Listener{

    public function onEnable()
    {
        Server::getInstance()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::GOLD . "Plugin created by Yanoox");
    }

    public function soupInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $item = $event->getItem();
        $itemName = $player->getInventory()->getItemInHand()->getName();
            if ($item->getId() == 459){
                if ($player->getHealth() == 20){
                    $player->sendPopup(TextFormat::RED . "/!\ Bar de vie pleine /!\ ");
                }
                else{
                    $player->setHealth($player->getHealth() + 10);
                    $player->getInventory()->removeItem(Item::get(459, 0,1));
                    $player->sendPopup(TextFormat::GREEN . "[+1]");
                }
        }
    }

    public function stackSoup(InventoryPickupItemEvent $event){
        $evItem = $event->getItem();
        $item = $evItem->getItem();
        $inventory = $event->getInventory();
        foreach ($inventory->getContents() as $slot => $invItem){
            if ($item->getId() == 459){
                $count = $item->getCount() + $invItem->getCount();
                if ($count < 64)
                $sItem = Item::get($item->getId(), $item->getDamage(), $count);
                $inventory->getItem($slot, $sItem);
                $item->setCount(0);
                break;
            }
        }
    }
}
