<?php

namespace Models;

use Services\ApiService;
use DateTime;

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
            $characterDataJson = ApiService::fetchDataFromApi($url);
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