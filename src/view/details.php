<!DOCTYPE html>
<html>
<head>
    <title><?= $movie->title; ?></title>
</head>
<body>
    <h1><?= $movie->title; ?> (Episódio <?= $movie->episode_id; ?>)</h1>
    <p><strong>Sinópse:</strong></p>
    <p><?= $movie->formattedOpeningCrawl(); ?></p>
    <p><strong>Data de Lançamento:</strong> <?= $movie->calculateAge()['formatted_date']; ?></p>
    <p><strong>Diretor:</strong> <?= $movie->director; ?></p>
    <p><strong>Produtor(es):</strong> <?= implode(', ', $movie->producer); ?></p>
    <p><strong>Personagens:</strong></p>
    <?php foreach ($movie->characters as $name): ?>
        <li>
            <?= $name; ?> 
        </li>
    <?php endforeach; ?>
    <p><strong>Idade do Filme:</strong> <?= $movie->calculateAge()['years']; ?> anos, <?= $movie->calculateAge()['months']; ?> meses, <?= $movie->calculateAge()['days']; ?> dias</p>   
    <p><strong>Total de Visualizações Neste Filme:</strong> <?= $viewCount; ?></p>
    <a href="index.php?action=catalog">Voltar ao Catálogo</a>
</body>
</html>