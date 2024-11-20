<?php

	require './vendor/autoload.php';

	\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
	\EasyRdf\RdfNamespace::set('university', 'http://www.semanticweb.org/hp/ontologies/2024/8/university.owl#');

	$sparql_jena = new \EasyRdf\Sparql\Client("http://localhost:3030/university/sparql");

?>