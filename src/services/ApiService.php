<?php

    namespace Services;

    class ApiService {
        public static function fetchDataFromApi($url) {
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
    }