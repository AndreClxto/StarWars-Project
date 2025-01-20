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
                    // Extract character names if needed (you may need an additional method to fetch character details)
                    $characterNames = $this->fetchCharacterNames($movieData['characters']);
                    $formattedCharacterNames = implode(", ", $characterNames);
        
                    // Insert the movie into the database
                    $this->dbHandler->insertFilm($movieData, $formattedCharacterNames);
                }
        
                // Fetch movie from the database and create a Movie object
                $movieDataFromDb = $this->dbHandler->getFilmByEpisodeId($episodeId);
                $movies[] = new Movie($movieDataFromDb);
            }
        
            // Sort movies by release date
            usort($movies, function ($a, $b) {
                $dateA = new \DateTime($a->release_date);
                $dateB = new \DateTime($b->release_date);
        
                return $dateA <=> $dateB;
            });
        
            include_once __DIR__ . '/../view/catalogs.php';
        }
        
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
            // Incrementa as visualizações no banco de dados
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
            // Inclui a view de detalhes
            include __DIR__ . '/../view/details.php';
        }
    }