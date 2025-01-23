# Documentação de Uso da API

Este projeto consome a API pública Star Wars (SWAPI) para obter informações sobre filmes da franquia.

A URL base para os endpoints da SWAPI é:

https://swapi.py4e.com/api/

### Endpoints Usados

- **GET /films/**: Retorna uma lista de filmes da franquia Star Wars.
    - Resposta esperada:
      ```json
      {
          "count": 6,
          "next": "https://swapi.py4e.com/api/films/?page=2",
          "previous": null,
          "results": [
              {
                  "title": "A New Hope",
                  "episode_id": 4,
                  "release_date": "1977-05-25",
                  "director": "George Lucas",
                  "producer": "Gary Kurtz, Rick McCallum",
                  "characters": [
                      "https://swapi.py4e.com/api/people/1/",
                      "https://swapi.py4e.com/api/people/2/"
                  ]
              }
              // Mais filmes...
          ]
      }
      ```

### Como a API é usada no projeto
1. O método `fetchDataFromApi($url)` da classe `ApiService` realiza uma chamada HTTP para o endpoint da API.
2. Os dados retornados são processados e armazenados no banco de dados.
3. Os dados são puxados do banco de dados e apresentados ao usuário

### Limitações
- A API externa pode sofrer instabilidades ou limitações de taxa. Para contornar isso, a aplicação faz cache dos dados no banco de dados, garantindo que as informações não precisem ser recarregadas a cada acesso.
