<?php
declare(strict_types=1);

namespace Nova\HelpBook;

use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\item\WrittenBook;
use pocketmine\item\VanillaItems;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener {
    
    public $cfg;
    
    public function onEnable() :void {
   	@mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
     }
 
    public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) :bool {
        if($sender instanceof Player) {
            switch($cmd->getName()) {
                case "helpbook":
                    $item = VanillaItems::WRITTEN_BOOK();
                    $item->setTitle($this->cfg->get("BookTitle"));
                    $item->setAuthor($this->cfg->get("BookAuthor"));
                    $player->getInventory()->addItem($this->setText($item, $sender));
                break;
            }
        }
        return true;
    }
    
    public function setText($item, $player) {
    	if(is_array($this->cfg->get("BookText"))) {
    	    for($num = 0; $num < count($this->cfg->get("BookText")); $num++) {
    	        $item->setPageText($num, str_replace(["{line}", "&"], ["\n", "§"], $this->cfg->get("BookText")[$num]));
            }
        } else {
            $item->setPageText(0, str_replace(["{line}", "&"], ["\n", "§"], $this->cfg->get("BookText")));
        }
        return $item;
    }
        
}
