<?php

	require './vendor/autoload.php';

	\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
	\EasyRdf\RdfNamespace::set('fil', 'http://example.org/movie#');

	$sparql_jena = new \EasyRdf\Sparql\Client("http://localhost:3030/filmlane/sparql");

	function search($input){
		$query ="
		SELECT ?Film WHERE {
			?Film fil:hasTitle ?namaFilm.
			FILTER (regex(?namaFilm, \"$input\", 'i'))
		}";
	}

?>