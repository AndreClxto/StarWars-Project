<?php
namespace Controllers;

// Importação das classes necessárias
use Models\Movie;
use Services\ApiService;
use Services\DataBaseHandler;

require_once __DIR__ . '/../services/DataBaseHandler.php';

class MovieController {
    private $dbHandler;

    // Array para os URLs dos pôsteres
    private $posterUrls = [
        1 => 'assets/images/episode1.jpg',
        2 => 'assets/images/episode2.jpg',
        3 => 'assets/images/episode3.jpg',
        4 => 'assets/images/episode4.jpg',
        5 => 'assets/images/episode5.jpg',
        6 => 'assets/images/episode6.jpg',
        7 => 'assets/images/episode7.jpg'
    ];

    public function __construct() {
        // Inicializa o objeto que manipula o banco de dados com os parâmetros de conexão
        $this->dbHandler = new DataBaseHandler('localhost', 'starwarsdb', 'root', '');
    }

    public function showCatalog() {
        // URL da API que retorna uma lista de filmes com diversas informações
        $url = 'https://swapi.py4e.com/api/films/';
        // Faz a requisição à API e decodifica o JSON em um array associativo
        $jsonData = ApiService::fetchDataFromApi($url);
        $data = json_decode($jsonData, true);
    
        $movies = []; // Array para armazenar os objetos de filmes
    
        foreach ($data['results'] as $movieData) {
            $episodeId = $movieData['episode_id']; // ID do episódio
            
            // Verifica se o filme já existe no banco de dados
            if (!$this->dbHandler->filmExists($episodeId)) {
                // Busca os nomes dos personagens relacionados ao filme
                $characterNames = $this->fetchCharacterNames($movieData['characters']);
                // Formata os nomes como uma string separada por vírgulas
                $formattedCharacterNames = implode(", ", $characterNames);
                // Insere as informações do filme no banco de dados se elas ja não estiverem lá
                $this->dbHandler->insertFilm($movieData, $formattedCharacterNames);
            }
    
            // Obtém os dados do filme diretamente do banco de dados
            $movieDataFromDb = $this->dbHandler->getFilmByEpisodeId($episodeId);
            // Cria um objeto Movie com os dados retornados
            $movies[] = new Movie($movieDataFromDb);
        }
    
        // Ordena os filmes por data de lançamento (crescente)
        usort($movies, function ($a, $b) {
            $dateA = new \DateTime($a->release_date); // Converte para DateTime
            $dateB = new \DateTime($b->release_date);
            return $dateA <=> $dateB; // Compara as datas
        });
        
        // Inclui a página de visualização do catálogo
        include_once __DIR__ . '/../view/catalogs.php';
    }
    
    // Método para traduzir os nomes dos personagens a partir das URLs fornecidas para um formato legível
    private function fetchCharacterNames($characterUrls) {
        $characterNames = []; // Array para armazenar os nomes dos personagens
        foreach ($characterUrls as $url) {
            // Faz a requisição para cada URL de personagem
            $jsonData = ApiService::fetchDataFromApi($url);
            $data = json_decode($jsonData, true);
            $characterNames[] = $data['name']; // Adiciona o nome do personagem ao array
        }
        return $characterNames; // Retorna a lista de nomes
    }

    public function showDetails($id) {
        // Incrementa o contador de visualizações do filme no banco de dados
        $this->dbHandler->incrementFilmViewCount($id);
        // Busca os dados do filme pelo ID do episódio
        $movieData = $this->dbHandler->getFilmByEpisodeId($id);
    
        // Verifica se o filme foi encontrado no banco de dados
        if (!$movieData) {
            echo "Filme não encontrado no banco de dados."; // Mensagem de erro
            return;
        }

        // Cria uma instância do objeto Movie com os dados do banco
        $movie = new Movie($movieData);
        // Obtém o número de visualizações do filme
        $viewCount = $this->dbHandler->getFilmViewCount($id);
        // A URL do poster também será passada para o template de detalhes
        $posterUrl = $this->posterUrls[$id] ?? ''; // Pegando a URL da imagem para o poster
        // Inclui a página de visualização de detalhes dos filmes
        include __DIR__ . '/../view/details.php';
    }
}
