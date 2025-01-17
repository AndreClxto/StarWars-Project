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
                $movies[] = new Movie($movieData);
            }

            usort($movies, function ($a, $b) {
                $dateA = new \DateTime($a->release_date);
                $dateB = new \DateTime($b->release_date);
            
                return $dateA <=> $dateB; // Compare dates in ascending order
            });

            include_once __DIR__ . '/../view/catalogs.php';
        }
            /*$moviesData = $this->dbHandler->getAllFilms();

            if(empty($moviesData)) {
                $moviesData = [];

                $url = 'https://swapi.py4e.com/api/films/';
                $jsonData = ApiService::fetchDataFromApi($url);
                $data = json_decode($jsonData, true);

                foreach($data['results'] as $movieData) {
                    $this->dbHandler->insertFilm($movieData);
                    $moviesData[] = $movieData;
                }
            }

            $movies = array_map(function ($movieData) {
                return new Movie($movieData);
            }, $moviesData);

            usort($movies, function ($a, $b) {
                $dateA = new \DateTime($a->release_date);
                $dateB = new \DateTime($b->release_date);
            
                return $dateA <=> $dateB; // Compare dates in ascending order
            });

            include_once __DIR__ . '/../view/catalogs.php';*/
        

        
            // Use the database handler to fetch the film details by episode ID
            //$dbHandler = new DataBaseHandler('localhost', 'starwarsdb', 'root', ''); // Replace with your actual database credentials
            //$filmData = $dbHandler->getFilmByEpisodeId($id);

        public function showDetails($id) {
            $url = "https://swapi.py4e.com/api/films/$id/";
            $jsonData = ApiService::fetchDataFromApi($url);
            $data = json_decode($jsonData, true);
    
            $movie = new Movie($data);
    
            include __DIR__ . '/../view/details.php';
        }

            /*if (!$filmData) {
                // If the film is not in the database, fetch it from the API, save it to the database, and then fetch it again
                $url = "https://swapi.py4e.com/api/films/$id/";
                $jsonData = ApiService::fetchDataFromApi($url);
                $data = json_decode($jsonData, true);

                if ($data) {
                    $movie = new Movie($data);
            
                    // Format the character names
                    $formattedCharacterNames = $movie->formatCharacterNames();

                    // Save the film to the database
                    $dbHandler->insertFilm($data, $formattedCharacterNames);

                    // Fetch the film from the database after insertion
                    $filmData = $dbHandler->getFilmByEpisodeId($id);
                }
            } else{
                // Create a Movie object using the database data
                $movie = new Movie($filmData);

                // Pass it to the view
                include __DIR__ . '/../view/details.php';
            }*/
    }