<?php
include "./inc/func.php";

if (isset($_GET['id'])) {
  $filmId = $_GET['id'];
}
$data = showDetail($filmId);
$genresStr = trim($data->genre, "[]");
$genresStr = str_replace("'", "", $genresStr);
$genres = explode(",", $genresStr);

$direktor = $data->direktor;
$id = $data->id;
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

<body id="#top">

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

          <select name="language" id="language">
            <option value="en">EN</option>
            <option value="au">AU</option>
            <option value="ar">AR</option>
            <option value="tu">TU</option>
          </select>
        </div>


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
            <a href="#" class="navbar-link">Pricing</a>
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
        - #MOVIE DETAIL
      -->

      <section class="movie-detail">
        <div class="container">
          <figure class="movie-detail-banner">
            <img src="<?= $data->image ?>" alt="<?= $data->namaFilm ?>">
            <button class="play-btn">
              <ion-icon name="play-circle-outline"></ion-icon>
            </button>
          </figure>
          <div class="movie-detail-content">
            <h2 class="h2 detail-title">
              <?= $data->namaFilm ?>
            </h2>
            <div class="meta-wrapper">
              <div class="badge-wrapper">
                <div class="badge badge-outline"><?= $data->country ?></div>
                <div class="badge badge-fill">HD</div>
              </div>
              <div class="date-time">
                <div>
                  <ion-icon name="calendar-outline"></ion-icon>
                  <time datetime="2021"><?= $data->rilis ?></time>
                </div>
                <div>
                  <ion-icon name="time-outline"></ion-icon>
                  <time datetime="PT115M"><?= $data->duration ?></time>
                </div>
                <div>
                  <ion-icon name="star"></ion-icon>
                  <data><?= $data->rating ?></data>
                </div>
              </div>
            </div>
            <div class="meta-wrapper">

              <div class="ganre-wrapper">
                <!-- <a href="#">Comedy,</a>
                <a href="#">Action,</a>
                <a href="#">Adventure,</a>
                <a href="#">Science Fiction</a> -->
                <?php foreach($genres as $genre) { ?>

                <a href="#">
                  <?= $genre ?>
                </a>

                <?php } ?>
              </div>

            </div>
            <p class="storyline">
              <?= $data->sinopsis ?>
            </p>
            <div class="meta-wrapper">
              <h3 class="h3 detail-title">
                Directed By
                <a href="#">
                  <?= $data->direktor ?>
                </a>
              </h3>
            </div>

            <!-- <div class="details-actions">
              <button class="share">
                <ion-icon name="share-social"></ion-icon>
                <span>Share</span>
              </button>
              <div class="title-wrapper">
                <p class="title">Prime Video</p>
                <p class="text">Streaming Channels</p>
              </div>
              <button class="btn btn-primary">
                <ion-icon name="play"></ion-icon>
                <span>Watch Now</span>
              </button>
            </div>  -->
            <!-- <ion-icon name="download-outline"></ion-icon> -->
            <!-- </a> -->

          </div>
        </div>
      </section>





      <!-- 
        - #TV SERIES
      -->

      <section class="tv-series">
        <div class="container">

          <!-- <p class="section-subtitle">Best TV Series</p> -->

          <h2 class="h2 section-title">FILM LAINNYA</h2>

          <ul class="movies-list has-scrollbar">
            <?php
              $res = showAnotherLikeFilm($direktor, $id);
              foreach ($res as $data) {
            ?>
              <li>
                <div class="movie-card">

                  <a href=".\movie-details.php?id=<?= $data->id ?>">
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
                      <?= $data->tahun ?>
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
        </div>
      </section>

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

            <li>
              <a href="#" class="footer-link">Pricing</a>
            </li>

          </ul>

        </div>

        <div class="divider"></div>

        <div class="quicklink-wrapper">

        </div>

      </div>
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

</body>

</html>