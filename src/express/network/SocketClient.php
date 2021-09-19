<?php

namespace express\network;

use express\network\utils\Addressable;
use express\network\utils\InternetAddress;
use Socket;
use function socket_getpeername;
use function socket_read;
use function socket_write;

class SocketClient extends Addressable {
	
	protected Socket|null $socket = null;
	
	public static function fromSocket(Socket $socket): SocketClient {
		socket_getpeername($socket, $address, $port);
		$c = new SocketClient(new InternetAddress($address, $port));
		$c->socket = $socket;
		return $c;
	}
	
	public function read(int $len): false|string {
		return socket_read($this->socket, $len);
	}
	
	public function write(string $buffer): bool {
		return (socket_write($this->socket, $buffer) === strlen($buffer));
	}
}