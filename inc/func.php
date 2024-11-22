<?php

	require './vendor/autoload.php';

	\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
	\EasyRdf\RdfNamespace::set('fil', 'http://example.org/movie#');


	
	function query($query){
		$sparql_jena = new \EasyRdf\Sparql\Client("http://localhost:3030/plot-twist/sparql");
		return $res = $sparql_jena->query($query);
	}
	function search($input){
		$query ="
		SELECT ?Film WHERE {
			?Film fil:hasTitle ?namaFilm.
			FILTER (regex(?namaFilm, \"$input\", 'i'))
		}";
	}


	function showFilm()
	{
		$query =
		" SELECT ?Film ?namaFilm ?rating ?image ?duration ?Tahun
		WHERE
		{
			?Film fil:hasTitle ?namaFilm .
			?Film fil:hasRating ?rating .
			?Film fil:hasImage ?image .
			?Film fil:hasDuration ?duration .
			?Film fil:hasYear ?Tahun .
			
		}
		";
		return query($query);
	}

?>