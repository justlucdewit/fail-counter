<?php
/**
 */

use \php\Boot;
use \php\Lib;
use \haxe\ds\StringMap;

class Router {
	/**
	 * @var bool
	 */
	public $has404;
	/**
	 * @var string
	 */
	public $path;
	/**
	 * @var StringMap
	 */
	public $registeredPaths;

	/**
	 * @return void
	 */
	public function __construct () {
		#Router.hx:11: characters 9-68
		$get = Lib::hashOfAssociativeArray($_GET);
		#Router.hx:12: characters 3-54
		$this->path = (array_key_exists("path", $get->data) ? ($get->data["path"] ?? null) : null);
		#Router.hx:14: characters 3-22
		$this->has404 = false;
		#Router.hx:15: characters 9-61
		$this->registeredPaths = new StringMap();
	}

	/**
	 * @param \Closure $callback
	 * 
	 * @return void
	 */
	public function notFound ($callback) {
		#Router.hx:25: characters 9-47
		$this->registeredPaths->data["404"] = $callback;
		#Router.hx:26: characters 9-27
		$this->has404 = true;
	}

	/**
	 * @param string $method
	 * @param string $path
	 * @param \Closure $callback
	 * 
	 * @return void
	 */
	public function registerPath ($method, $path, $callback) {
		#Router.hx:19: lines 19-21
		if ($method === $_SERVER["REQUEST_METHOD"]) {
			#Router.hx:20: characters 13-50
			$this->registeredPaths->data[$path] = $callback;
		}
	}

	/**
	 * @return void
	 */
	public function run () {
		#Router.hx:30: characters 6-24
		$found = false;
		#Router.hx:33: lines 33-35
		if (!\StringTools::endsWith($this->path, "/")) {
			#Router.hx:34: characters 13-22
			$this->path = ($this->path??'null') . "/";
		}
		#Router.hx:39: characters 44-64
		$map = $this->registeredPaths;
		$_g_map = $map;
		$_g_keys = $map->keys();
		#Router.hx:39: lines 39-45
		while ($_g_keys->hasNext()) {
			#Router.hx:39: characters 44-64
			$key = $_g_keys->next();
			$_g1_value = $_g_map->get($key);
			$_g1_key = $key;
			$registeredPath = $_g1_key;
			$callback = $_g1_value;
			#Router.hx:40: lines 40-44
			if ($this->path === $registeredPath) {
				#Router.hx:41: characters 17-27
				$callback();
				#Router.hx:42: characters 17-22
				$found = true;
				#Router.hx:43: characters 17-22
				break;
			}
		}
		#Router.hx:48: lines 48-50
		if (!$found && $this->has404) {
			#Router.hx:49: characters 13-42
			($this->registeredPaths->data["404"] ?? null)();
		}
	}
}

Boot::registerClass(Router::class, 'Router');
