<?php
    namespace Controllers;

    use Models\Movie;
    use Services\ApiService;
    use Services\DataBaseHandler;

    require_once __DIR__ . '/../services/DataBaseHandler.php';

    class MovieController {
        private $dbHandler;

        public function __construct() {
            $this->dbHandler = new DataBaseHandler('localhost', 'starwarsdb', 'root', '');
        }

        public function showCatalog() {
            $url = 'https://swapi.py4e.com/api/films/';
            $jsonData = ApiService::fetchDataFromApi($url);
            $data = json_decode($jsonData, true);
        
            $movies = [];
        
            foreach ($data['results'] as $movieData) {
                $episodeId = $movieData['episode_id'];
                if (!$this->dbHandler->filmExists($episodeId)) {
                    // Extrai a lista de nomes de personagens da api pelo método: fetchCharacterNames()
                    $characterNames = $this->fetchCharacterNames($movieData['characters']);
                    // Transforma o filme em uma string cujos elementos (nomes de personagens), são separados por vírgulas
                    $formattedCharacterNames = implode(", ", $characterNames);
        
                    // Insere o filme com suas informações na base de dados
                    $this->dbHandler->insertFilm($movieData, $formattedCharacterNames);
                }
        
                // Puxa o filme da base de dados
                $movieDataFromDb = $this->dbHandler->getFilmByEpisodeId($episodeId);
                // Cria um objeto Movie com as informações coletadas
                $movies[] = new Movie($movieDataFromDb);
            }
        
            // Organiza os filmes por data de lançamento
            usort($movies, function ($a, $b) {
                $dateA = new \DateTime($a->release_date);
                $dateB = new \DateTime($b->release_date);
        
                return $dateA <=> $dateB;
            });
            
            // Inclui a página de catálogo
            include_once __DIR__ . '/../view/catalogs.php';
        }
        
        // O método abaixo obtém os nomes dos personagens que estão em forma de url e os adiciona para uma lista characterNames com nomes legíveis
        private function fetchCharacterNames($characterUrls) {
            $characterNames = [];
            foreach ($characterUrls as $url) {
                $jsonData = ApiService::fetchDataFromApi($url);
                $data = json_decode($jsonData, true);
                $characterNames[] = $data['name'];
            }
            return $characterNames;
        }

        public function showDetails($id) {
            // Incrementa o número de visualizações no banco de dados
            $this->dbHandler->incrementFilmViewCount($id);
            // Busca os dados do filme a partir do banco de dados
            $movieData = $this->dbHandler->getFilmByEpisodeId($id);
        
            if (!$movieData) {
                echo "Filme não encontrado no banco de dados.";
                return;
            }

            // Cria uma instância do objeto Movie com os dados do banco
            $movie = new Movie($movieData);
            // Obtém a contagem de visualizações do filme
            $viewCount = $this->dbHandler->getFilmViewCount($id);
            // Inclui a página de detalhes dos filmes
            include __DIR__ . '/../view/details.php';
        }
    }