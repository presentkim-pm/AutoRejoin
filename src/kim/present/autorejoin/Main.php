<?php

/**
 *  ____                           _   _  ___
 * |  _ \ _ __ ___  ___  ___ _ __ | |_| |/ (_)_ __ ___
 * | |_) | '__/ _ \/ __|/ _ \ '_ \| __| ' /| | '_ ` _ \
 * |  __/| | |  __/\__ \  __/ | | | |_| . \| | | | | | |
 * |_|   |_|  \___||___/\___|_| |_|\__|_|\_\_|_| |_| |_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author       PresentKim (debe3721@gmail.com)
 * @link         https://github.com/PresentKim
 * @license      https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 *
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace kim\present\autorejoin;

use kim\present\removeplugindatafolder\PluginDataFolderEraser;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Internet;

final class Main extends PluginBase{
	private const LOCALHOST = "127.0.0.1";

	protected function onLoad() : void{
		PluginDataFolderEraser::erase($this);
	}

	protected function onDisable() : void{
		if(!$this->getServer()->isRunning()){
			$this->transferPlayers();
		}
	}

	private function transferPlayers() : void{
		$server = $this->getServer();

		$ip = Internet::getIP();
		$port = $server->getPort();
		foreach($server->getOnlinePlayers() as $player){
			$player->transfer(
				address: $player->getNetworkSession()->getIp() === self::LOCALHOST ? self::LOCALHOST : $ip,
				port: $port,
				message: "§cServer is stopped, please wait..."
			);
		}
	}
}
