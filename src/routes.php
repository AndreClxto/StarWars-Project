<?php

    use Controllers\MovieController;

    require __DIR__ . '/controller/MovieController.php';
    require __DIR__ . '/model/Movie.php';
    require __DIR__ . '/services/ApiService.php';

    $action = $_GET['action'] ?? 'catalog';
    $id = $_GET['id'] ?? null;

    $controller = new MovieController;

    if ($action === 'catalog') {
        $controller->showCatalog();
    } elseif ($action === 'details' && $id) {
        $controller->showDetails($id);
    } else {
        echo "Página não encontrada :(";
    }