<?php

namespace express\network\utils;

use JetBrains\PhpStorm\Pure;
use function explode;

class InternetAddress {
	
	public const LOCALHOST = "127.0.0.1";
	
	public function __construct(protected string $address, protected int $port = 0) { }
	
	/**
	 * @return string
	 */
	public function getAddress(): string {
		return $this->address;
	}
	
	/**
	 * @return int
	 */
	public function getPort(): int {
		return $this->port;
	}
	
	public function __toString(): string {
		return $this->address . ":" . $this->port;
	}
	
	#[Pure] public static function fromString(string $address): InternetAddress {
		return new InternetAddress(...explode(":", $address));
	}
}