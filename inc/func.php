<?php
require './vendor/autoload.php';

\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
\EasyRdf\RdfNamespace::set('fil', 'http://example.org/movie#');

function query($query) {
    $sparql_jena = new \EasyRdf\Sparql\Client("http://localhost:3030/plot-twist/sparql");
    return $sparql_jena->query($query);
}

// function search($input) {
//     $query = "
//     SELECT ?Film WHERE {
//         ?Film fil:hasTitle ?namaFilm.
//         FILTER (regex(?namaFilm, \"$input\", 'i'))
//     }";
//     return query($query);
// }

function showFilm($keyword, $page, $itemsPerPage) {
    // Calculate offset
    $offset = ($page - 1) * $itemsPerPage;
    
    $query = "
    SELECT ?Film ?namaFilm ?rating ?image ?duration ?Tahun
    WHERE {
        ?Film fil:hasTitle ?namaFilm .
        ?Film fil:hasRating ?rating .
        ?Film fil:hasImage ?image .
        ?Film fil:hasDuration ?duration .
        ?Film fil:hasYear ?Tahun .

		FILTER(REGEX(?namaFilm, '$keyword', 'i') ||
			   REGEX(?Tahun, '$keyword', 'i') ||
			   REGEX() . 
    }
    ORDER BY ?namaFilm
    LIMIT " . $itemsPerPage . "
    OFFSET " . $offset;
    
    return query($query);
}

function getTotalFilms() {
    $query = "
    SELECT (COUNT(?Film) as ?count)
    WHERE {
        ?Film fil:hasTitle ?namaFilm .
    }";
    
    $result = query($query);
    foreach ($result as $row) {
        return $row->count->getValue();
    }
    return 0;
}

// Pagination helper function
function generatePaginationData($currentPage, $totalItems, $itemsPerPage) {
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = max(1, min($currentPage, $totalPages));
    
    // Calculate the range of page numbers to show
    $start = max(1, $currentPage - 1);
    $end = min($start + 2, $totalPages);
    
    // Adjust start if we're near the end
    if ($end - $start < 2) {
        $start = max(1, $end - 2);
    }
    
    return [
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'start' => $start,
        'end' => $end,
        'hasNext' => $currentPage < $totalPages,
        'hasPrev' => $currentPage > 1
    ];
}
?>