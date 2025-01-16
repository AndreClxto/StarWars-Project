<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Filmes</title>
</head>
<body>
    <h1>Star Wars</h1>
    <ul>
        <?php foreach ($movies as $movie): ?>
            <li>
                <a href="index.php?action=details&id=<?= $movie->episode_id; ?>">
                    <?= $movie->title; ?> (<?= $movie->calculateAge()['formatted_date']; ?>)
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>