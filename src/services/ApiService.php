<?php

namespace Services;

class ApiService {
    // Método estático para buscar dados de uma API a partir de uma URL fornecida
    public static function fetchDataFromApi($url) {
        $ch = curl_init(); // Inicializa o cURL

        // Configurações do cURL
        curl_setopt($ch, CURLOPT_URL, $url); // Define a URL da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Retorna a resposta como string, em vez de exibir diretamente
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Segue redirecionamentos, se existirem
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignora verificação de certificado SSL

        $response = curl_exec($ch); // Executa a requisição e armazena a resposta

        // Verifica se houve algum erro durante a execução da requisição
        if(curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch); // Exibe o erro do cURL
            return null; // Retorna null em caso de erro
        }

        curl_close($ch); // Fecha a sessão do cURL

        return $response; // Retorna a resposta obtida
    }
}
