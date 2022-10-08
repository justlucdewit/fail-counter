<?php
/**
 */

namespace haxe\ds;

use \php\Boot;
use \haxe\IMap;
use \php\_NativeIndexedArray\NativeIndexedArrayIterator;

/**
 * StringMap allows mapping of String keys to arbitrary values.
 * See `Map` for documentation details.
 * @see https://haxe.org/manual/std-Map.html
 */
class StringMap implements IMap {
	/**
	 * @var array
	 */
	public $data;

	/**
	 * Creates a new StringMap.
	 * 
	 * @return void
	 */
	public function __construct () {
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/StringMap.hx:35: characters 10-32
		$this1 = [];
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/StringMap.hx:35: characters 3-32
		$this->data = $this1;
	}

	/**
	 * See `Map.get`
	 * 
	 * @param string $key
	 * 
	 * @return mixed
	 */
	public function get ($key) {
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/StringMap.hx:43: characters 3-42
		return ($this->data[$key] ?? null);
	}

	/**
	 * See `Map.keys`
	 * (cs, java) Implementation detail: Do not `set()` any new value while
	 * iterating, as it may cause a resize, which will break iteration.
	 * 
	 * @return object
	 */
	public function keys () {
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/ds/StringMap.hx:60: characters 10-72
		return new NativeIndexedArrayIterator(\array_values(\array_map("strval", \array_keys($this->data))));
	}
}

Boot::registerClass(StringMap::class, 'haxe.ds.StringMap');