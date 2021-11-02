<?php

use express\App;
use express\io\Request;
use express\io\Response;

require "src/express/App.php";

$app = new App();

$app->get("/", function (Request $request, Response $response) : void {
	$response->body("test");
});

$app->listen(80);