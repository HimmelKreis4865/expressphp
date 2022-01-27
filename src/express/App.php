<?php

namespace express;

use Closure;
use express\io\Response;
use express\route\Router;
use express\utils\Utils;
use express\network\Processor;
use express\network\SocketServer;
use express\network\utils\InternetAddress;
use function spl_autoload_register;
use function str_starts_with;
use function substr;
use function usleep;

final class App {
	
	protected ?Processor $processor = null;
	
	protected Router $router;
	
	protected ?Closure $invalidUrlHandler = null;
	
	public function __construct() { $this->init(); }
	
	private function init(): void {
		$this->autoload();
		$this->router = new Router();
	}
	
	public function listen(int $port, ?Closure $onStart = null): void {
		$sock = new SocketServer(new InternetAddress(InternetAddress::LOCALHOST, $port));
		$sock->start();
		$this->processor = new Processor($this, $sock);
		if ($onStart !== null) $onStart();
		$this->internalStart();
	}
	
	public function stop(): void {
	
	}
	
	public function get(string $path, Closure $closure): void {
		$this->router->add(Router::GET, $path, $closure);
	}
	
	public function post(string $path, Closure $closure): void {
		$this->router->add(Router::POST, $path, $closure);
	}
	
	public function put(string $path, Closure $closure): void {
		$this->router->add(Router::PUT, $path, $closure);
	}
	
	public function patch(string $path, Closure $closure): void {
		$this->router->add(Router::PATCH, $path, $closure);
	}
	
	public function delete(string $path, Closure $closure): void {
		$this->router->add(Router::DELETE, $path, $closure);
	}
	
	public function default(Closure $closure): void {
		$this->invalidUrlHandler = $closure;
	}
	
	/**
	 * @internal
	 *
	 * @param InternetAddress $address
	 * @param string $request
	 *
	 * @return string
	 */
	public function __internalReceiveRequest(InternetAddress $address, string $request): string {
		$request =  Utils::parseRequest($address, $request);
		//var_dump("method: " . $request->getRequestData()->getMethod(), "path: " . $request->getRequestData()->getPath(), "queries:", $request->getRequestData()->getQueries());
		if ($this->router->isRegistered($request)) {
			return $this->router->execute($request);
		}
		$response = new Response(404);
		if ($this->invalidUrlHandler !== null) ($this->invalidUrlHandler)($request, $response);
		return $response;
	}
	
	private function internalStart(): void {
		while (true) {
			usleep(1000 * 50);
			$this->tick();
		}
	}
	
	private function tick(): void {
		$this->processor->tick();
	}
	
	private function autoload(): void {
		spl_autoload_register(function (string $class): void {
			if (str_starts_with($class, "express")) require __DIR__ . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, substr($class, strlen("express"))) . ".php";
		});
	}
}
