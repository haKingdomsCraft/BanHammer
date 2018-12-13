<?php
namespace ElementalMinecraftGaming\BanHammer;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\server;
use pocketmine\Player;
use pocketmine\command\defaults\BanIpCommand;
use pocketmine\event\entity\EntityDamageEvent;
class Main extends PluginBase implements listener {
    private $hasBh = [];
    public function onEnable() {
        $this->getLogger()->info("Ban Hammer has been enabled!");
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool { 
        if ($sender->hasPermission("player.bh")) {
            if (strtolower($command->getName()) == "enablehammer") {
                if ($sender instanceof Player) {
                    $sender->sendMessage(TextFormat::BLUE . "Ban hammer activated!") ;
                    $this->hasPc[$sender->getName()] = true;
                    return true;
                } else {
                    $sender->sendMessage(TextFormat::RED . "Incorrect potato!");
                    return false;
                }
            }
        }
        if ($sender->hasPermission("player.bhd")) {
            if (strtolower($command->getName()) == "disablehammer") {
                if ($sender instanceof Player) {
                    $sender->sendMessage(TextFormat::GOLD . "Deactivated Ban Hammer");
                    if (isset($this->hasPc[$event->getPlayer()->getName()])) {
                        unset($this->hasPc[$event->getPlayer()->getName()]);
                    }
                    return true;
                } else {
                    $sender->sendMessage(TextFormat::RED . "Incorrect potato!");
                    return false;
                }
            }
        }
    }
    public function onQuit(PlayerQuitEvent $event) {
        if (isset($this->hasBh[$event->getPlayer()->getName()])) {
            unset($this->hasBh[$event->getPlayer()->getName()]);
        }
    }
    public function onEntityDamage(EntityDamageEvent $event) {
        if (isset($this->hasBh[$event->getPlayer()->getName()])) {
            $target = $event->getEntity() ;
            $player = $event->getPlayer();
            $reason = "Breaking rules or annoying staff";
            $this->processIPBan($target->getAddress(), $player, $reason);
        }
    }
}
