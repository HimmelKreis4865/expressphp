<?php

namespace express\network\utils;

abstract class Addressable {
	
	public function __construct(protected InternetAddress $address) { }
	
	/**
	 * @return InternetAddress
	 */
	public function getAddress(): InternetAddress {
		return $this->address;
	}
}