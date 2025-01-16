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
            'years' => $interval->y,
            'months' => $interval->m,
            'days' => $interval->d
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



// A partir daqui tem q ser em outro lugar. Mas por enquanto vai ficar por aqui msm.

function fetchDataFromApi($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if(curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
        return null;
    }

    curl_close($ch);

    return $response;
}

$url = 'https://swapi.py4e.com/api/films/2/';

// Fetch the data from the API using cURL
$jsonData = fetchDataFromApi($url);

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