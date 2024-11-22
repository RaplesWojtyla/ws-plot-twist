<?php
// Fungsi untuk melakukan query SPARQL
function querySearch($sparqlQuery) {
    $endpoint = "http://localhost:3030/filmLane/query";  // Endpoint SPARQL
    $url = $endpoint . "?query=" . urlencode($sparqlQuery) . "&format=json";
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    return $data['results']['bindings'];
}

// Fungsi untuk menampilkan film berdasarkan query pencarian
function showFilm($query = null) {
    // Jika ada query pencarian
    if ($query) {
        $sparqlQuery = "
            SELECT ?Film ?namaFilm ?rating ?image ?duration
            WHERE {
                ?Film fil:hasTitle ?namaFilm .
                ?Film fil:hasRating ?rating .
                ?Film fil:hasImage ?image .
                ?Film fil:hasDuration ?duration .
                FILTER(CONTAINS(LCASE(?namaFilm), LCASE('$query')))
            }
        ";
    } else {
        // Query default untuk mengambil semua film
        $sparqlQuery = "
            SELECT ?Film ?namaFilm ?rating ?image ?duration
            WHERE {
                ?Film fil:hasTitle ?namaFilm .
                ?Film fil:hasRating ?rating .
                ?Film fil:hasImage ?image .
                ?Film fil:hasDuration ?duration .
            }
        ";
    }

    return querySearch($sparqlQuery);
}

// Cek jika ada permintaan AJAX
if (isset($_GET['ajax_query'])) {
    $searchQuery = $_GET['ajax_query'];
    $films = showFilm($searchQuery);

    // Kembalikan hasil dalam format JSON
    echo json_encode($films);
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plot-Twist</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <main>
        <article>
            <!-- HERO Section -->
            <section class="hero">
                <div class="container">
                    <div class="hero-content">
                        <p class="hero-subtitle">Filmlane</p>
                        <h1 class="h1 hero-title">
                            Unlimited <strong>Movie</strong>, TV Shows, & More.
                        </h1>
                    </div>

                    <!-- Search Bar -->
                    <div class="search-bar">
                        <form action="#" method="GET">
                            <input type="text" name="query" id="searchInput" placeholder="Search for movies, TV shows, and more..." class="search-input" oninput="liveSearch()">
                            <button type="submit" class="search-button">
                                <ion-icon name="search-outline"></ion-icon>
                            </button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Movies List Section -->
            <section class="upcoming">
                <div class="container">
                    <ul class="movies-list" id="moviesList">
                        <!-- Movie Cards will be loaded dynamically via JavaScript -->
                    </ul>
                </div>
            </section>
        </article>
    </main>

    <!-- Scripts -->
    <script>
        // Function for live search
        function liveSearch() {
            const input = document.getElementById('searchInput').value.trim();
            const moviesList = document.getElementById('moviesList');

            // Kirim permintaan AJAX ke PHP untuk melakukan pencarian SPARQL
            fetch(`search.php?ajax_query=${input}`)
                .then(response => response.json())
                .then(data => {
                    // Kosongkan daftar film
                    moviesList.innerHTML = '';

                    // Tambahkan data hasil pencarian
                    data.forEach(movie => {
                        const li = document.createElement('li');
                        li.innerHTML = `
                            <div class="movie-card">
                                <a href="movie-details.php?Film=${movie.Film.value}">
                                    <figure class="card-banner">
                                        <img src="${movie.image.value}" alt="${movie.namaFilm.value} movie poster">
                                    </figure>
                                </a>
                                <div class="title-wrapper">
                                    <a href="movie-details.php?Film=${movie.Film.value}">
                                        <h3 class="card-title">${movie.namaFilm.value}</h3>
                                    </a>
                                </div>
                                <div class="card-meta">
                                    <div class="badge badge-outline">HD</div>
                                    <div class="duration">
                                        <ion-icon name="time-outline"></ion-icon>
                                        <time datetime="PT137M">${movie.duration.value}</time>
                                    </div>
                                    <div class="rating">
                                        <ion-icon name="star"></ion-icon>
                                        <data>${movie.rating.value}</data>
                                    </div>
                                </div>
                            </div>
                        `;
                        moviesList.appendChild(li);
                    });
                });
        }

     
    </script>
       <script src="./assets/js/script.js"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
