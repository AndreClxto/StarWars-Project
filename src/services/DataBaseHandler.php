<?php

namespace Services;

class DataBaseHandler {
    private $mysqli; // Propriedade para armazenar a conexão com o banco de dados

    // Construtor para inicializar a conexão com o banco de dados
    public function __construct($host, $db, $user, $pass) {
        $this->mysqli = new \mysqli($host, $user, $pass, $db); // Conexão com o banco de dados

        // Verifica se houve erro na conexão
        if ($this->mysqli->connect_error) {
            die("Database connection failed: " . $this->mysqli->connect_error); // Encerra o script com a mensagem de erro
        }

        $this->mysqli->set_charset("utf8mb4"); // Configura o conjunto de caracteres para evitar problemas com acentos e caracteres especiais
    }

    // Método para verificar se um filme já existe no banco de dados
    public function filmExists($episode_id) {
        $query = "SELECT COUNT(*) AS count FROM films WHERE episode_id = ?"; // Consulta para contar registros com o episode_id
        $stmt = $this->mysqli->prepare($query); // Prepara a consulta
        $stmt->bind_param("i", $episode_id); // Substitui o placeholder (?) pelo valor da variável
        $stmt->execute(); // Executa a consulta
        
        $result = $stmt->get_result(); // Obtém o resultado da consulta
        $row = $result->fetch_assoc(); // Transforma o resultado em um array associativo
        
        return $row['count'] > 0; // Retorna verdadeiro se o filme já existe
    }

    // Método para inserir um filme no banco de dados
    public function insertFilm($films, $formattedCharacterNames) {
        $query = "
            INSERT INTO films (title, episode_id, opening_crawl, release_date, director, producer, characters)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        "; // Query para inserir um novo filme
        $stmt = $this->mysqli->prepare($query); // Prepara a consulta

        $producer = isset($films['producer']) ? $films['producer'] : 'Unknown'; // Verifica se o produtor está definido
        $characters = $formattedCharacterNames; // Lista formatada de personagens

        // Vincula os valores aos placeholders da consulta
        $stmt->bind_param("sisssss",
            $films['title'], 
            $films['episode_id'], 
            $films['opening_crawl'], 
            $films['release_date'], 
            $films['director'], 
            $producer,
            $characters
        );

        $stmt->execute(); // Executa a consulta
    }

    // Método para buscar um filme pelo episode_id
    public function getFilmByEpisodeId($episode_id) {
        $query = "SELECT * FROM films WHERE episode_id = ?"; // Consulta para buscar o filme
        $stmt = $this->mysqli->prepare($query); // Prepara a consulta
        $stmt->bind_param("i", $episode_id); // Vincula o ID do episódio
        $stmt->execute(); // Executa a consulta
        
        $result = $stmt->get_result(); // Obtém o resultado da consulta
        return $result->fetch_assoc(); // Retorna os dados do filme como array associativo
    }

    // Método para obter o contador de visualizações de um filme
    public function getFilmViewCount($episode_id) {
        $query = "SELECT view_count FROM films WHERE episode_id = ?"; // Consulta para buscar o contador
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $episode_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row ? $row['view_count'] : 0; // Retorna 0 se o filme não for encontrado
    }

    // Método para incrementar o contador de visualizações de um filme
    public function incrementFilmViewCount($episode_id) {
        $query = "UPDATE films SET view_count = view_count + 1 WHERE episode_id = ?"; // Atualiza o contador
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $episode_id);
        $stmt->execute();
    }

    // Método para registrar logs de requisições no banco de dados
    public function logRequest($url, $method, $params) {
        $query = "
            INSERT INTO logs (request_time, request_url, request_method, request_params, ip_address)
            VALUES (?, ?, ?, ?, ?)
        "; // Consulta para inserir um log
        $stmt = $this->mysqli->prepare($query);

        if (!$stmt) {
            die("Query preparation failed: " . $this->mysqli->error); // Interrompe o script em caso de erro
        }

        $requestTime = date('Y-m-d H:i:s'); // Formata o horário da requisição
        $requestParams = json_encode($params); // Converte os parâmetros em JSON
        $ipAddress = $_SERVER['REMOTE_ADDR']; // Obtém o endereço IP do cliente

        // Vincula os parâmetros
        $stmt->bind_param("sssss", $requestTime, $url, $method, $requestParams, $ipAddress);
        $stmt->execute();

        if ($stmt->error) {
            die("Query execution failed: " . $stmt->error); // Interrompe o script em caso de erro na execução
        }

        $stmt->close(); // Fecha o statement
    }
}
