<?php

namespace Models;

// Importação de classes necessárias
use Services\ApiService;
use Services\DataBaseHandler;
use DateTime;

class Movie {
    // Propriedades públicas que representam os atributos de um filme
    public $title;           // Título do filme
    public $episode_id;      // ID do episódio (número do filme)
    public $opening_crawl;   // Sinópse (rolagem inicial dos filmes Star Wars)
    public $release_date;    // Data de lançamento
    public $director;        // Diretor do filme
    public $producer;        // Produtores (armazenados como array)
    public $characters;      // Lista de personagens (armazenada como array)

    public function __construct($data) {
        // Inicializa as propriedades com os dados recebidos
        $this->title = $data['title']; // Título do filme
        $this->episode_id = $data['episode_id']; // Número do episódio
        $this->opening_crawl = $data['opening_crawl']; // Sinópse
        $this->release_date = $data['release_date']; // Data de lançamento
        $this->director = $data['director']; // Nome do diretor

        // Divide os nomes dos produtores em um array, separados por vírgulas
        $this->producer = explode(', ', $data['producer']); 
        
        // Divide os nomes dos personagens em um array
        $this->characters = explode(', ', $data['characters']);
    }

    // Método para calcular a idade do filme (em dias, meses e anos) com base na data de lançamento
    public function calculateAge() {
        $releaseDate = new DateTime($this->release_date); // Converte a data de lançamento em um objeto DateTime
        $now = new DateTime(); // Data atual
        $interval = $releaseDate->diff($now); // Calcula a diferença entre a data de lançamento e a atual

        // Retorna a idade do filme em anos, meses, dias e uma data formatada
        $formattedDate = $releaseDate->format('d/m/Y'); // Formata a data no padrão brasileiro
        return [
            'formatted_date' => $formattedDate, // Data formatada para o padrão brasileiro
            'days' => $interval->d,             // Dias de diferença
            'months' => $interval->m,           // Meses de diferença
            'years' => $interval->y             // Anos de diferença
        ];
    }

    // Método para formatar o sinópse (opening crawl)
    public function formattedOpeningCrawl() {
        // Substitui as quebras de linha por tags <br> para exibição em HTML
        return nl2br($this->opening_crawl);
    }
}
