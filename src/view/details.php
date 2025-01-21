<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $movie->title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/starwars_project/src/assets/css/styles.css">
</head>
<body class="text-dark">
    <div class="container py-5">
        <h1 class="mb-3"><?= $movie->title; ?> (Episódio <?= $movie->episode_id; ?>)</h1>
        <img src="<?= $movie->poster_url; ?>" alt="<?= $movie->title; ?> Poster" class="movie-details-poster">
        <p><strong>Sinópse:</strong></p>
        <blockquote class="bg-dark text-light p-3 rounded"><?= $movie->formattedOpeningCrawl(); ?></blockquote>
        <p><strong>Data de Lançamento:</strong> <?= $movie->calculateAge()['formatted_date']; ?></p>
        <p><strong>Diretor:</strong> <?= $movie->director; ?></p>
        <p><strong>Produtor(es):</strong> <?= implode(', ', $movie->producer); ?></p>
        <p><strong>Personagens:</strong></p>
        <ul class="list-group">
            <?php foreach ($movie->characters as $name): ?>
                <li class="list-group-item"><?= $name; ?> </li>
            <?php endforeach; ?>
        </ul>
        <p class="mt-4"><strong>Idade do Filme:</strong> <?= $movie->calculateAge()['years']; ?> anos, <?= $movie->calculateAge()['months']; ?> meses, <?= $movie->calculateAge()['days']; ?> dias</p>   
        <p class="mt-4"><strong>Total de Visualizações Neste Filme:</strong> <?= $viewCount; ?></p>
        <a href="index.php?action=catalog" class="btn btn-secondary mb-4">Voltar ao Catálogo</a>
    </div>
</body>
</html>