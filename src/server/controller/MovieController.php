<?php

    namespace Controllers;

    use Models\Movie;
    use Services\ApiService;

    class MovieController {

        public function showCatalog() {
            $url = 'https://swapi.py4e.com/api/films/';
            $jsonData = ApiService::fetchDataFromApi($url);
            $data = json_decode($jsonData, true);

            $movies = [];

            foreach ($data['results'] as $movieData) {
                $movies[] = new Movie($movieData);
            }

            include_once __DIR__ . '/../view/catalogs.php';
        }

        public function showDetails($id) {
            $url = "https://swapi.py4e.com/api/films/$id/";
            $jsonData = ApiService::fetchDataFromApi($url);
            $data = json_decode($jsonData, true);
    
            $movie = new Movie($data);
    
            include __DIR__ . '/../view/details.php';
        }

    }