<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Filmes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/starwars_project/src/assets/css/styles.css">
</head>
<body class="text-dark">
    <div class="container py-5">
        <h1 class="text-center mb-4">Catálogo Star Wars</h1>
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por título...">
        </div>
        <ul id="moviesContainer" class="list-group">
            <?php foreach ($movies as $movie): ?>
                <li class="list-group-item justify-content-between align-items-center movie-item">
                    <a href="index.php?action=details&id=<?= $movie->episode_id; ?>" class="text-decoration-none">
                        <img src="<?= $movie->poster_url; ?>" alt="<?= $movie->title; ?> Poster" class="movie-poster" style="width: 50px; height: 75px;">
                        <?= $movie->title; ?> (<?= $movie->calculateAge()['formatted_date']; ?>)
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();  // Get search input and trim extra spaces
            const movies = document.querySelectorAll('.movie-item');  // Get all movie items

            movies.forEach(movie => {
                const titleElement = movie.querySelector('a');  // Get the title element inside the movie item
                const title = titleElement ? titleElement.textContent.trim().toLowerCase() : '';

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
