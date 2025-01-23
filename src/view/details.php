<!DOCTYPE html>
<html>
<head>
    <!-- Configuração básica da página -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ajusta o layout para dispositivos móveis -->
    <title><?= $movie->title; ?></title> <!-- Título dinâmico baseado no nome do filme -->

    <!-- Importação do CSS do Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Importação de estilos personalizados -->
    <link rel="stylesheet" href="/starwars_project/src/assets/css/styles.css">
</head>
<body class="text-dark"> <!-- Define a cor do texto como escura -->

    <div class="container py-5"> <!-- Container principal com padding vertical -->
        <!-- Título do filme e número do episódio -->
        <h1 class="mb-3"><?= $movie->title; ?> (Episódio <?= $movie->episode_id; ?>)</h1>

        <!-- Exibição do pôster do filme -->
        <img src="<?= $posterUrl; ?>" alt="<?= $movie->title; ?> Poster" class="movie-details-poster">
        
        <!-- Sinopse do filme -->
        <p><strong>Sinópse:</strong></p>
        <blockquote class="bg-dark text-light p-3 rounded"><?= $movie->formattedOpeningCrawl(); ?></blockquote>
        <!-- A sinopse é formatada com quebras de linha convertidas para tags <br> -->

        <!-- Informações do filme -->
        <p><strong>Data de Lançamento:</strong> <?= $movie->calculateAge()['formatted_date']; ?></p> <!-- Data de lançamento formatada -->
        <p><strong>Diretor:</strong> <?= $movie->director; ?></p> <!-- Nome do diretor -->
        <p><strong>Produtor(es):</strong> <?= implode(', ', $movie->producer); ?></p> <!-- Lista de produtores separados por vírgula -->

        <!-- Lista de personagens -->
        <p><strong>Personagens:</strong></p>
        <ul class="list-group"> <!-- Lista estilizada com Bootstrap -->
            <?php foreach ($movie->characters as $name): ?> <!-- Itera sobre os personagens -->
                <li class="list-group-item"><?= $name; ?></li> <!-- Exibe o nome de cada personagem -->
            <?php endforeach; ?>
        </ul>

        <!-- Idade do filme em anos, meses e dias -->
        <p class="mt-4"><strong>Idade do Filme:</strong> 
            <?= $movie->calculateAge()['years']; ?> anos, 
            <?= $movie->calculateAge()['months']; ?> meses, 
            <?= $movie->calculateAge()['days']; ?> dias
        </p>

        <!-- Contagem total de visualizações nesta página -->
        <p class="mt-4"><strong>Total de Visualizações Neste Filme:</strong> <?= $viewCount; ?></p>

        <!-- Botão para voltar ao catálogo -->
        <a href="index.php?action=catalog" class="btn btn-secondary mb-4">Voltar ao Catálogo</a>
    </div>
</body>
</html>
