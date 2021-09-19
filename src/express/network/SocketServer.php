<?php

namespace express\network;

use express\network\utils\Addressable;
use Socket;
use function socket_accept;
use function socket_bind;
use function socket_create;
use function socket_listen;
use function socket_set_nonblock;
use const AF_INET;
use const SOCK_STREAM;
use const SOL_TCP;

class SocketServer extends Addressable {
	
	protected Socket|null $socket = null;
	
	public function start(bool $listen = true, bool $blocking = false): bool {
		$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if (!socket_bind($this->socket, $this->address->getAddress(), $this->address->getPort())) return false;
		if (!$blocking) socket_set_nonblock($this->socket);
		if ($listen) return socket_listen($this->socket);
		return true;
	}
	
	public function accept(): ?SocketClient {
		if ($c = socket_accept($this->socket)) return SocketClient::fromSocket($c);
		return null;
	}
}