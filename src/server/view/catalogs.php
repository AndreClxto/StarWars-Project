<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Filmes</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Star Wars</h1>
    <input type="text" id="searchInput" placeholder="Buscar por título...">
    <ul id="moviesContainer">
        <?php foreach ($movies as $movie): ?>
            <li class="movie-item">
                <a href="index.php?action=details&id=<?= $movie->episode_id; ?>">
                    <?= $movie->title; ?> (<?= $movie->calculateAge()['formatted_date']; ?>)
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const query = this.value.toLowerCase();  // Get search input
            const movies = document.querySelectorAll('.movie-item');  // Get all movie items

            movies.forEach(movie => {
                const title = movie.querySelector('a').textContent.toLowerCase();  // Get title text

                // Only show the movie if the title matches the query
                if (title.includes(query)) {
                    movie.style.display = '';  // Show the movie item
                } else {
                    movie.style.display = 'none';  // Hide the movie item
                }
            });
        });
    </script>
</body>
</html>
