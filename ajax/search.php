<?php
require '../inc/func.php';
?>


<ul class="movies-list">
    <?php
    if (isset($_POST['keyword'])) {
        $keyword = str_replace(["'", '"', "-"], "", $_POST['keyword']);
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $totalItems = getTotalFilms($keyword);
        $itemsPerPage = 20;
        $paginationData = generatePaginationData($currentPage, $totalItems, $itemsPerPage);

        $results = showFilm($keyword, $currentPage, itemsPerPage: $itemsPerPage);

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
<div class="pagination" id="pagination">
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