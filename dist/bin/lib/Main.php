<?php
/**
 */

use \php\Boot;
use \php\Lib;
use \sys\io\File;
use \haxe\Json;

class Main {
	/**
	 * @return mixed
	 */
	public static function getFailCount () {
		#Main.hx:33: characters 9-67
		$appState = File::getContent("../appstate.json");
		#Main.hx:36: characters 9-54
		$appStateJson = Json::phpJsonDecode($appState);
		#Main.hx:39: characters 9-34
		return $appStateJson->fails;
	}

	/**
	 * @return void
	 */
	public static function incrementFailCount () {
		#Main.hx:44: characters 9-67
		$appState = File::getContent("../appstate.json");
		#Main.hx:47: characters 9-54
		$appStateJson = Json::phpJsonDecode($appState);
		#Main.hx:50: characters 9-29
		$appStateJson->fails++;
		#Main.hx:53: characters 9-87
		File::saveContent("../appstate.json", Json::phpJsonEncode($appStateJson, null, null));
	}

	/**
	 * @return void
	 */
	public static function main () {
		#Main.hx:6: characters 9-30
		$r = new \Router();
		#Main.hx:8: characters 9-69
		header("Access-Control-Allow-Origin: *");;
		#Main.hx:9: characters 9-70
		header("Access-Control-Allow-Headers: *");;
		#Main.hx:10: characters 9-70
		header("Access-Control-Allow-Methods: *");;
		#Main.hx:12: lines 12-15
		$r->registerPath("GET", "api/", function () {
			#Main.hx:13: characters 13-40
			Lib::println(Main::getFailCount());
		});
		#Main.hx:17: lines 17-26
		$r->registerPath("POST", "api/", function () {
			#Main.hx:18: characters 13-53
			$pass = $_GET["pass"];
			#Main.hx:19: characters 13-77
			$correct_pass = File::getContent("../password.secret");
			#Main.hx:21: lines 21-23
			if ($pass === $correct_pass) {
				#Main.hx:22: characters 17-37
				Main::incrementFailCount();
			}
		});
		#Main.hx:28: characters 9-16
		$r->run();
	}

	/**
	 * @return void
	 */
	public function __construct () {
	}
}

Boot::registerClass(Main::class, 'Main');
