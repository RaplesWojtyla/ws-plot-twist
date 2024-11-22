<?php

	require './vendor/autoload.php';

	\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
	\EasyRdf\RdfNamespace::set('fil', 'http://example.org/movie#');


	
	function query($query){
		$sparql_jena = new \EasyRdf\Sparql\Client("http://localhost:3030/filmLane/sparql");
		return $res = $sparql_jena->query($query);
	}
	
	function search($input){
		$query =
		" SELECT ?Film ?namaFilm ?rating ?image ?duration 
		WHERE
		{
			?Film fil:hasTitle ?namaFilm .
			?Film fil:hasRating ?rating .
			?Film fil:hasImage ?image .
			?Film fil:hasDuration ?duration .  
		}
			FILTER (regex(?namaFilm, \"$input\", 'i'))
		";
		return query($query);
	}




	function showFilm()
	{
		$query =
		" SELECT ?Film ?namaFilm ?rating ?image ?duration 
		WHERE
		{
			?Film fil:hasTitle ?namaFilm .
			?Film fil:hasRating ?rating .
			?Film fil:hasImage ?image .
			?Film fil:hasDuration ?duration .  
		}
		";
		return query($query);
	}

?>