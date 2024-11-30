<?php
require '../inc/func.php';

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $results = searchByTitle($keyword, 3);

    foreach ($results as $result) {
        echo '<div>';
        echo '<a href=".\pages\movie-details.php?id=' . $result->id . '">';
        echo '<p>' . $result->namaFilm . '</p>';
		echo '</a>';
        echo '</div>';
    }
}
?>