<?php
  require './inc/func.php';
  $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
  $keyword = isset($_GET['search']) ? $_GET['search'] : "";
  $totalItems = getTotalFilms($keyword);
  $itemsPerPage = 20;
  $paginationData = generatePaginationData($currentPage, $totalItems, $itemsPerPage);
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

<body id="top">
  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <div class="overlay" data-overlay></div>

      <a href="./index.php" class="logo">
        <img src="./assets/images/logo.svg" alt="Filmlane logo">
      </a>

      <div class="header-actions">

        <button class="search-btn">
          <ion-icon name="search-outline"></ion-icon>
        </button>

        <div class="lang-wrapper">
          <label for="language">
            <ion-icon name="globe-outline"></ion-icon>
          </label>



        </div>

        <button class="menu-open-btn" data-menu-open-btn>
          <ion-icon name="reorder-two"></ion-icon>
        </button>

        <nav class="navbar" data-navbar>

          <div class="navbar-top">

            <a href="./index.php" class="logo">
              <img src="./assets/images/logo.svg" alt="Filmlane logo">
            </a>

            <button class="menu-close-btn" data-menu-close-btn>
              <ion-icon name="close-outline"></ion-icon>
            </button>

          </div>

          <ul class="navbar-list">

            <li>
              <a href="./index.php" class="navbar-link">Home</a>
            </li>

            <li>
              <a href="#" class="navbar-link">Movie</a> 
            </li>

            <li>
              <a href="#" class="navbar-link">Tv Show</a>
            </li>

            <li>
              <a href="#" class="navbar-link">Web Series</a>
            </li>

            <li>
              <a href="#" class="navbar-link">Show Genre</a>
            </li>

          </ul>

          <ul class="navbar-social-list">

            <li>
              <a href="#" class="navbar-social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="navbar-social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="navbar-social-link">
                <ion-icon name="logo-pinterest"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="navbar-social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="navbar-social-link">
                <ion-icon name="logo-youtube"></ion-icon>
              </a>
            </li>

          </ul>

        </nav>

      </div>
  </header>

  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section class="hero">
        <div class="container">
          <div class="hero-content">
            <p class="hero-subtitle">Plot Twist</p>
            <h1 class="h1 hero-title">
              Unlimited <strong>Movie</strong>, TVs Shows, & More.
            </h1>
          </div>

          <!-- Search Bar -->
          <div class="search-bar">
            <form method="GET">
              <input type="text" name="search" id="search" placeholder="Search for movies, TV shows, and more..."
                class="search-input" value="<?= htmlspecialchars($keyword) ?>">
              <button name="searchBtn" type="submit" class="search-button">
                <ion-icon name="search-outline"></ion-icon>
              </button>
            </form>
          </div>
          <div id="search-results"></div>
        </div>
      </section>


      <!-- 
        - #UPCOMING
      -->

      <section class="upcoming">
        <div class="container">

          <div class="flex-wrapper">

            <div class="title-wrapper">
              <p class="section-subtitle">Searching Movies</p>

              <h2 class="h2 section-title">Movies</h2>
            </div>

            <ul class="filter-list">
              <li class="dropdown">
                <button class="filter-btn" id="dropdownToggle">
                  Genre
                  <span class="arrow-down"></span>
                </button>
                <ul class="dropdown-menu" id="dropdownMenu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Comedy</a></li>
                  <li><a href="#">Drama</a></li>
                  <li><a href="#">Horror</a></li>
                  <li><a href="#">Romance</a></li>
                  <li><a href="#">Adventure</a></li>
                  <li><a href="#">Thriller</a></li>
                  <li><a href="#">Mystery</a></li>
                  <li><a href="#">Science Fiction</a></li>
                  <li><a href="#">History</a></li>
                  <li><a href="#">Family</a></li>
                  <li><a href="#">Animation</a></li>
                  <li><a href="#">Crime</a></li>
                  <li><a href="#">War</a></li>
                  <li><a href="#">Anime</a></li>
                  <li><a href="#">Music</a></li>
                  <li><a href="#">Western</a></li>
                  <li><a href="#">Drama</a></li>
                  <li><a href="#">Documentary</a></li>
                  <li><a href="#">Kids</a></li>
                </ul>
              </li>


              <!-- <li>
                <button class="filter-btn">TV Shows</button>
              </li>

              <li>
                <button class="filter-btn">Anime</button>
              </li> -->

            </ul>

          </div>

          <ul class="movies-list">

            <?php
            $res = showFilm($keyword, $currentPage, $itemsPerPage);
            foreach ($res as $data) {
            ?>

            <li>
              <div class="movie-card">

                <a href=".\pages\movie-details.php?id=<?= $data->id ?>">
                  <figure class="card-banner">
                    <img src="<?= $data->image ?>" alt="<?= $data->namaFilm ?>">
                  </figure>
                </a>

                <div class="title-wrapper">
                  <a href=".\movie-details.php?id=<?= $data->id ?>">
                    <h3 class="card-title">
                      <?= $data->namaFilm ?>
                    </h3>
                  </a>

                  <time datetime="2022">
                    <?= $data->Tahun ?>
                  </time>
                </div>

                <div class="card-meta">
                  <div class="badge badge-outline">HD</div>

                  <div class="duration">
                    <ion-icon name="time-outline"></ion-icon>

                    <time datetime="PT137M"><?= $data->duration ?></time>
                  </div>

                  <div class="rating">
                    <ion-icon name="star"></ion-icon>

                    <data><?= $data->rating ?></data>
                  </div>
                </div>

              </div>
            </li>
            <?php } ?>
          </ul>
          <!-- Pagination -->

          <!-- Updated pagination section -->
          <div class="pagination">
            <?php if ($paginationData['hasPrev']): ?>
            <a href="?page=<?= ($currentPage - 1); ?>&search=<?= urlencode($keyword); ?>" class="pagination-btn prev">Previous</a>
            <?php else: ?>
            <span class="pagination-btn prev disabled">Previous</span>
            <?php endif; ?>

            <span class="page-numbers">
              <?php for ($i = $paginationData['start']; $i <= $paginationData['end']; $i++): ?>
              <a href="?page=<?= $i; ?>&search=<?= urlencode($keyword); ?>"
                class="pagination-btn <?php echo ($i == $currentPage) ? 'active' : ''; ?>"
                data-page="<?php echo $i; ?>">
                <?php echo $i; ?>
              </a>
              <?php endfor; ?>
            </span>

            <?php if ($paginationData['hasNext']): ?>
            <a href="?page=<?= ($currentPage + 1); ?>&search=<?= urlencode($keyword); ?>" class="pagination-btn next">Next</a>
            <?php else: ?>
            <span class="pagination-btn next disabled">Next</span>
            <?php endif; ?>
          </div>


        </div>
      </section>





      <!-- 
        - #SERVICE
      -->

    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer">

    <div class="footer-top">
      <div class="container">

        <div class="footer-brand-wrapper">

          <a href="./index.php" class="logo">
            <img src="./assets/images/logo.svg" alt="Filmlane logo">
          </a>

          <ul class="footer-list">

            <li>
              <a href="./index.php" class="footer-link">Home</a>
            </li>

            <li>
              <a href="#" class="footer-link">Movie</a>
            </li>

            <li>
              <a href="#" class="footer-link">TV Show</a>
            </li>

            <li>
              <a href="#" class="footer-link">Web Series</a>
            </li>

          </ul>

        </div>


        <div class="quicklink-wrapper">

        </div>

      </div>
    </div>

    <div class="footer-bottom">

    </div>

  </footer>





  <!-- 
    - #GO TO TOP
  -->

  <a href="#top" class="go-top" data-go-top>
    <ion-icon name="chevron-up"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function() {
      $('#search').on('input', function() {
          var keyword = $(this).val();
          if (keyword.length > 1) {
              $.ajax({
                  url: './ajax/search.php',
                  type: 'GET',
                  data: { keyword: keyword },
                  success: function(data) {
                      $('#search-results').html(data);
                  }
              });
          } else {
              $('#search-results').empty();
          }
      });
  });
  </script>
  <script>
    $(document).ready(function() {
      $('#dropdownMenu li').on('click', function() {
        var genre = $(this).text().trim();

        searchByGenre(genre);
      });
    });

    function searchByGenre(genre) {
      console.log('Searching for genre:', genre); // Tes output
      window.location.href = 'index.php?search=' + encodeURIComponent(genre);
    }
  </script>
</body>

</html>