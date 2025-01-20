<?php

    namespace Services;

    class DataBaseHandler {
        private $mysqli;

        public function __construct($host, $db, $user, $pass) {
            $this->mysqli = new \mysqli($host, $user, $pass, $db);

            if ($this->mysqli->connect_error) {
                die("Database connection failed: " . $this->mysqli->connect_error);
            }

            $this->mysqli->set_charset("utf8mb4");
        }

        public function filmExists($episode_id) {
            $query = "SELECT COUNT(*) AS count FROM films WHERE episode_id = ?";
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param("i", $episode_id);
            $stmt->execute();
        
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        
            return $row['count'] > 0;
        }

        public function insertFilm($films, $formattedCharacterNames) {
            $query = "
                INSERT INTO films (title, episode_id, opening_crawl, release_date, director, producer, characters)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ";
            $stmt = $this->mysqli->prepare($query);
        
            $producers = isset($films['producer']) ? $films['producer'] : 'Unknown';
            $characters = $formattedCharacterNames;
        
            $stmt->bind_param("sisssss",
                $films['title'], 
                $films['episode_id'], 
                $films['opening_crawl'], 
                $films['release_date'], 
                $films['director'], 
                $producer,
                $characters
            );

            $stmt->execute();
        }

        public function getFilmByEpisodeId($episode_id) {
            $query = "SELECT * FROM films WHERE episode_id = ?";
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param("i", $episode_id);
            $stmt->execute();
        
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }

        public function getFilmViewCount($episode_id) {
            $query = "SELECT view_count FROM films WHERE episode_id = ?";
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param("i", $episode_id);
            $stmt->execute();
        
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        
            return $row ? $row['view_count'] : 0; // Retorna 0 se o filme não for encontrado
        }

        public function incrementFilmViewCount($episode_id) {
            $query = "UPDATE films SET view_count = view_count + 1 WHERE episode_id = ?";
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param("i", $episode_id);
            $stmt->execute();
        }

    }
