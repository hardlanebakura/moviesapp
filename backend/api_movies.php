<?php

    //read from JSON and write the content into the database
    require_once("Database.php");
    require_once("movies_database.php");

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    header('Content-Type: application/json');

    function api_items() {

        global $genres;
        $db = new db();
        $top_movies = $db -> query("SELECT * FROM movies")->fetchAll();

        print_r(json_encode(array(
            "top_movies"=>$top_movies,
            "genres"=>$genres
        )));

    }

    api_items();

?>