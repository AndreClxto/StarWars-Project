<?php

    // Este arquivo reúne todo o código do projeto e manda para o index.php

    // Importa as classes necessárias
    use Controllers\MovieController;
    use Services\DataBaseHandler;

    // Inclui os arquivos requeridos para o funcionamento do projeto
    require_once __DIR__ . '/controller/MovieController.php'; // Controlador
    require_once __DIR__ . '/model/Movie.php';                // Modelo de filmes
    require_once __DIR__ . '/services/ApiService.php';        // Serviço para integração com APIs externas
    require_once __DIR__ . '/services/DataBaseHandler.php';   // Serviço para manipulação do banco de dados

    $dbHandler = new DataBaseHandler('localhost', 'starwarsdb', 'root', ''); // Inicia o databasehandler e configuração com host, banco de dados, usuário e senha

    // Captura os dados da requisição HTTP
    $url = $_SERVER['REQUEST_URI'];                  // Obtém a URL completa da requisição
    $method = $_SERVER['REQUEST_METHOD'];            // Determina o método da requisição (GET ou POST)
    $params = ($method === 'GET') ? $_GET : $_POST;  // Obtém os parâmetros da requisição com base no método

    // Registra a requisição no banco de dados para fins de auditoria
    $dbHandler->logRequest($url, $method, $params);

    // Lógica para definir as rotas
    $action = $_GET['action'] ?? 'catalog'; // Obtém a ação especificada na URL; padrão é 'catalog'
    $id = $_GET['id'] ?? null;              // Obtém o ID do filme, se fornecido

    // Instancia o controlador de filmes
    $controller = new MovieController();

    // Direciona a execução com base na ação especificada
    if ($action === 'catalog') {
        $controller->showCatalog(); // Exibe o catálogo de filmes
    } elseif ($action === 'details' && $id) {
        $controller->showDetails($id); // Exibe os detalhes de um filme específico
    } else {
        // Exibe uma mensagem de erro para ações desconhecidas
        echo "Página não encontrada :(";
    }
