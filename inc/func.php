<?php
require __DIR__ . '/../vendor/autoload.php';

\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
\EasyRdf\RdfNamespace::set('fil', 'http://example.org/movie#');

function query($query) 
{
    $sparql_jena = new \EasyRdf\Sparql\Client("http://localhost:3030/plot-twist/sparql");
    return $sparql_jena->query($query);
}

function showFilm($keyword, $page, $itemsPerPage) 
{
    $offset = ($page - 1) * $itemsPerPage;
    
    $query = "
    SELECT ?Film ?id ?namaFilm ?rating ?image ?duration ?Tahun
    WHERE {
        ?Film fil:hasId ?id .
        ?Film fil:hasTitle ?namaFilm .
        ?Film fil:hasRating ?rating .
        ?Film fil:hasImage ?image .
        ?Film fil:hasDuration ?duration .
        ?Film fil:hasYear ?Tahun .
        ?Film fil:hasDirector ?director .
        ?Film fil:hasCountry ?country .
        ?Film fil:hasGenres ?genre .


		FILTER(CONTAINS(LCASE(?namaFilm), LCASE('$keyword')) ||
			   CONTAINS(LCASE(?Tahun), LCASE('$keyword')) ||
               CONTAINS(LCASE(?director), LCASE('$keyword')) ||
               CONTAINS(LCASE(?country), LCASE('$keyword')) ||
               CONTAINS(LCASE(?genre), LCASE('$keyword')) 
                ) .
    }
    ORDER BY ?namaFilm
    LIMIT " . $itemsPerPage . "
    OFFSET " . $offset;

    return query($query);
}

function sortByRate($keyword, $page, $itemsPerPage) 
{
    $offset = ($page - 1) * $itemsPerPage;
    
    if ($keyword == "Highest")
    {
        $query = "
        SELECT ?Film ?id ?namaFilm ?rating ?image ?duration ?Tahun
        WHERE {
            ?Film fil:hasId ?id .
            ?Film fil:hasTitle ?namaFilm .
            ?Film fil:hasRating ?rating .
            ?Film fil:hasImage ?image .
            ?Film fil:hasDuration ?duration .
            ?Film fil:hasYear ?Tahun .
            ?Film fil:hasDirector ?director .
            ?Film fil:hasCountry ?country .
            ?Film fil:hasGenres ?genre .
        }
        ORDER BY DESC(?rating)
        LIMIT " . $itemsPerPage . "
        OFFSET " . $offset;
    }
    else 
    {
        $query = "
        SELECT ?Film ?id ?namaFilm ?rating ?image ?duration ?Tahun
        WHERE {
            ?Film fil:hasId ?id .
            ?Film fil:hasTitle ?namaFilm .
            ?Film fil:hasRating ?rating .
            ?Film fil:hasImage ?image .
            ?Film fil:hasDuration ?duration .
            ?Film fil:hasYear ?Tahun .
            ?Film fil:hasDirector ?director .
            ?Film fil:hasCountry ?country .
            ?Film fil:hasGenres ?genre .
        }
        ORDER BY ASC(?rating)
        LIMIT " . $itemsPerPage . "
        OFFSET " . $offset;
    }

    return query($query);
}

function getTotalFilms($keyword) 
{
    $keyword = ($keyword == "Highest") || ($keyword == "Lowest") ? "" : $keyword;

    $query = "
    SELECT (COUNT(?Film) as ?count)
    WHERE {
        ?Film fil:hasTitle ?namaFilm .
        ?Film fil:hasYear ?Tahun .
        ?Film fil:hasDirector ?director .
        ?Film fil:hasCountry ?country .
        ?Film fil:hasGenres ?genre .

        FILTER(
			   REGEX(?namaFilm, '$keyword', 'i') ||
               REGEX(?Tahun, '$keyword', 'i') ||
               REGEX(?director, '$keyword', 'i') ||
               REGEX(?country, '$keyword', 'i') ||
               CONTAINS(?genre, '$keyword') 
        ) .
    }";
    
    $result = query($query);

    foreach ($result as $row) {
        return $row->count->getValue();
    }

    return 0;
}

// Pagination helper function
function generatePaginationData($currentPage, $totalItems, $itemsPerPage) 
{
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = max(1, min($currentPage, $totalPages));
    
    // Calculate the range of page numbers to show
    $start = max(1, $currentPage - 1);
    $end = min($start + 4, $totalPages);
    
    // Adjust start if we're near the end
    if ($end - $start < 4) {
        $start = max(1, $end - 4);
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

function showDetail($id) 
{
    
    $query = "
    SELECT ?Film ?id ?rilis ?country ?direktor ?namaFilm ?genre ?rating ?image ?duration ?tahun ?sinopsis
    WHERE {
        ?Film fil:hasTitle ?namaFilm .
        ?Film fil:hasGenres ?genre .
        ?Film fil:hasRating ?rating .
        ?Film fil:hasImage ?image .
        ?Film fil:hasDuration ?duration .
        ?Film fil:hasYear ?tahun .
        ?Film fil:hasId ?id .
        ?Film fil:hasReleaseDate ?rilis .
        ?Film fil:hasSinopsis ?sinopsis .
        ?Film fil:hasCountry ?country .
        ?Film fil:hasDirector ?direktor .

        FILTER (?id = $id)
    } #GROUP BY ?Film ?id ?rilis ?country ?direktor ?namaFilm ?rating ?image ?duration ?tahun ?sinopsis
    ";

    return query($query)->current();
}

function showAnotherLikeFilm($direktor, $id, $genres="") 
{
    
    $query = "
    SELECT ?Film ?id ?namaFilm ?rating ?image ?duration ?tahun 
    WHERE {
        ?Film fil:hasTitle ?namaFilm .
        ?Film fil:hasRating ?rating .
        ?Film fil:hasImage ?image .
        ?Film fil:hasDuration ?duration .
        ?Film fil:hasYear ?tahun .
        ?Film fil:hasId ?id .
        ?Film fil:hasDirector ?direktor .
        ?Film fil:hasGenres ?genre .

        FILTER (regex(?direktor , '$direktor' , 'i') && (?id != $id))
    }LIMIT 8
    ";

    return query($query);
}

?>