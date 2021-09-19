<?php

use express\App;

require "src/express/App.php";

$app = new App();

$app->listen(80);