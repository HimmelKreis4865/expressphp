<?php

namespace express\utils;

use ArrayAccess;
use Volatile;

class Collection extends Volatile implements ArrayAccess {
	
	public function offsetExists($offset): bool {
		return isset($this[$offset]);
	}
	
	public function has($offset): bool {
		return $this->offsetExists($offset);
	}
	
	public function get($offset): mixed {
		return $this->offsetGet($offset);
	}
	
	public function set($offset, $value): void {
		$this->offsetSet($offset, $value);
	}
	
	public function fill(array $array): void {
		foreach ($array as $k => $v) {
			$this->set($k, $v);
		}
	}
	
	public function offsetGet($offset): mixed {
		return $this[$offset];
	}
	
	public function offsetSet($offset, $value): void {
		$this[$offset] = $value;
	}
	
	public function offsetUnset($offset): void {
		unset($this[$offset]);
	}
	
	public static function fromArray(array $array): Collection {
		$c = new Collection();
		$c->fill($array);
		return $c;
	}
}