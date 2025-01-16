<?php

require_once __DIR__ . '/server/services/ApiService.php';
require_once __DIR__ . '/server/controller/MovieController.php';
require_once __DIR__ . '/server/model/Movie.php';

use Controllers\MovieController;

$controller = new MovieController();
$controller->showCatalog();