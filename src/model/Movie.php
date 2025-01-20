<?php

namespace Models;

use Services\ApiService;
use Services\DataBaseHandler;
use DateTime;

class Movie {
    public $title;
    public $episode_id;
    public $opening_crawl;
    public $release_date;
    public $director;
    public $producer;
    public $characters;

    public function __construct($data) {
        $this->title = $data['title'];
        $this->episode_id = $data['episode_id'];
        $this->opening_crawl = $data['opening_crawl'];
        $this->release_date = $data['release_date'];
        $this->director = $data['director'];
        $this->producer = explode(', ' , $data['producer']);
        $this->characters = isset($data['characters']) ? explode(', ', $data['characters']) : [];
    }

    public function calculateAge() {
        $releaseDate = new DateTime($this->release_date); 
        $now = new DateTime();
        $interval = $releaseDate -> diff($now);
        $formattedDate = $releaseDate->format('d/m/Y');
        return [
            'formatted_date' => $formattedDate,
            'days' => $interval->d,
            'months' => $interval->m,
            'years' => $interval->y
        ];
    }

    public function formattedOpeningCrawl() {
        return nl2br($this->opening_crawl); // Converte as quebras de linha em tags <br> para melhor manuseio.
    }
}