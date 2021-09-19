<?php

namespace express\io\data;

use express\network\utils\InternetAddress;
use express\utils\Collection;

class RequestData {
	
	public function __construct(protected InternetAddress $requestAddress, protected string $method, protected string $path, protected Collection $queries) { }
	
	/**
	 * @return InternetAddress
	 */
	public function address(): InternetAddress {
		return $this->requestAddress;
	}
	
	/**
	 * @return string
	 */
	public function method(): string {
		return $this->method;
	}
	
	/**
	 * @return string
	 */
	public function path(): string {
		return $this->path;
	}
	
	/**
	 * @return Collection
	 */
	public function queries(): Collection {
		return $this->queries;
	}
}