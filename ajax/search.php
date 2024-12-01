<?php
require '../inc/func.php';
?>


<ul class="movies-list">
    <?php
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $results = searchByTitle($keyword, 20);

        foreach ($results as $result) { ?>
            <li>
                <div class="movie-card">
                    <a href="./pages/movie-details.php?id=<?= htmlspecialchars($result->id); ?>">
                        <figure class="card-banner">
                            <img src="<?= htmlspecialchars($result->image); ?>" alt="<?= htmlspecialchars($result->namaFilm); ?>">
                        </figure>
                    </a>
                    <div class="title-wrapper">
                        <a href="./movie-details.php?id=<?= htmlspecialchars($result->id); ?>">
                            <h3 class="card-title"><?= htmlspecialchars($result->namaFilm); ?></h3>
                        </a>
                        <time datetime="<?= htmlspecialchars($result->Tahun); ?>"><?= htmlspecialchars($result->Tahun); ?></time>
                    </div>
                    <div class="card-meta">
                        <div class="badge badge-outline">HD</div>
                        <div class="duration">
                            <ion-icon name="time-outline"></ion-icon>
                            <time datetime="PT137M"><?= htmlspecialchars($result->duration); ?></time>
                        </div>
                        <div class="rating">
                            <ion-icon name="star"></ion-icon>
                            <data><?= htmlspecialchars($result->rating); ?></data>
                        </div>
                    </div>
                </div>
            </li>
        <?php } 
    } ?>
</ul>
