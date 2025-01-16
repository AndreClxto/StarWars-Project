<?php

class Movie {
    public $title;
    public $episode_id;
    public $opening_crawl;
    public $release_date;
    public $director;
    public $producers;
    public $characters;

    public function __construct($data) {
        $this->title = $data['title'];
        $this->episode_id = $data['episode_id'];
        $this->opening_crawl = $data['opening_crawl'];
        $this->release_date = $data['release_date'];
        $this->director = $data['director'];
        $this->producers = explode(', ' , $data['producer']);
        $this->characters = $data['characters'];
    }

    public function calculateAge() {
        $releaseDate = new DateTime($this->release_date); 
        $now = new DateTime();
        $interval = $releaseDate -> diff($now);
        return [
            'days' => $interval->d,
            'months' => $interval->m,
            'years' => $interval->y
        ];
    }

    public function formattedOpeningCrawl() {
        return nl2br($this->opening_crawl); // Converte as quebras de linha em tags <br> para melhor manuseio.
    }

    public function formatCharacterNames() {
        $characterNames = []; // Initialize an array to store character names
    
        foreach ($this->characters as $url) {
            // Fetch character details from the API
            $characterDataJson = fetchDataFromApi($url);
            // Decode the JSON data
            $characterData = json_decode($characterDataJson, true);
            // Extract the name and add it to the array
            if (isset($characterData['name'])) {
                $characterNames[] = $characterData['name'];
            }
        }

        return $characterNames;
    }
}

$url = 'https://swapi.py4e.com/api/films/3/';

// Fetch the data from the API using cURL
$jsonData =>fetchDataFromApi($url);

// Transformando a informacao recebida em json para codigo php
$data = json_decode($jsonData, true);

// Create a Movie object using the fetched data
$movie = new Movie($data);

// Get the movie's age
$age = $movie->calculateAge();

// Format the opening crawl text for HTML output
$openingCrawl = $movie->formattedOpeningCrawl(); 

// Lista de personagens em formato apresentável
$characterList = $movie->formatCharacterNames();

echo "Título: " . $movie->title . "<br>";
echo "Episódio: " . $movie->episode_id . "<br>";
echo "Diretor: " . $movie->director . "<br>";
echo "Produtor(es): " . implode(', ', $movie->producers) . "<br>";
echo "Data de Lançamento: " . $movie->release_date . "<br>";
echo "<h3>Sinópse:</h3>" . $openingCrawl . "<br><br>";
echo "<h4>Personagens:</h4>" . implode(';<br>' , $characterList) . "<br><br>";
echo "<h4>Idade do Filme:</h4> " . $age['years'] . " anos, " . $age['months'] . " meses, e " . $age['days'] . " dias<br>";