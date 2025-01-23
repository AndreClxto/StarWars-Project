<!DOCTYPE html>
<html>
<head>
    <!-- Configuração de metadados -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ajusta o layout para dispositivos móveis -->
    <title>Catálogo de Filmes</title> <!-- Título da página -->

    <!-- Importa o CSS do Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Importa o css do projeto -->
    <link rel="stylesheet" href="/starwars_project/src/assets/css/styles.css">
</head>
<body class="text-dark"> <!-- Define a cor do texto como escura -->
    <div class="container py-5"> <!-- Container principal com padding vertical -->
        <h1 class="text-center mb-4">Catálogo Star Wars</h1> <!-- Título centralizado com margem inferior -->

        <!-- Campo de busca -->
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por título..."> 
            <!-- Input de texto para pesquisa com estilos do Bootstrap -->
        </div>

        <!-- Lista de filmes -->
        <ul id="moviesContainer" class="list-group">
            <?php foreach ($movies as $movie): ?> <!-- Itera sobre a lista de filmes disponível em $movies -->
                <li class="list-group-item justify-content-between align-items-center movie-item">
                    <!-- Cada item da lista representa um filme -->
                    <a href="index.php?action=details&id=<?= $movie->episode_id; ?>" class="text-decoration-none">
                        <!-- Link para a página de detalhes do filme -->
                        <img src="/starwars_project/src/assets/images/episode<?= $movie->episode_id; ?>.jpg" alt="<?= $movie->title; ?> Poster" style="width: 50px; height: 75px;">
                        <!-- Imagem do pôster do filme com dimensões fixas -->
                        <?= $movie->title; ?> (<?= $movie->calculateAge()['formatted_date']; ?>)
                        <!-- Exibe o título do filme e sua data de lançamento formatada -->
                    </a>
                </li>
            <?php endforeach; ?> <!-- Finaliza o loop -->
        </ul>
    </div>

    <!-- Script para funcionalidade de busca -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            // Obtém o texto digitado pelo usuário e remove espaços extras
            const query = this.value.toLowerCase().trim();

            // Seleciona todos os itens da lista de filmes
            const movies = document.querySelectorAll('.movie-item');

            movies.forEach(movie => {
                // Obtém o elemento do título dentro do item do filme
                const titleElement = movie.querySelector('a');
                const title = titleElement ? titleElement.textContent.trim().toLowerCase() : '';

                // Mostra ou oculta o filme dependendo da correspondência do título com o texto de busca
                if (title.includes(query)) {
                    movie.style.display = ''; // Exibe o item
                } else {
                    movie.style.display = 'none'; // Oculta o item
                }
            });
        });
    </script>
</body>
</html>
