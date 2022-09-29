<?php

    //read from JSON and write the content into the database
    require_once("Database.php");
    require_once("movies_database.php");

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    header('Content-Type: application/json');

    function getSelectedMovie() {

        $movie_id = json_decode(file_get_contents("php://input"), true);
        $db = new db();
    
        $query = $db->query("SELECT * FROM movies AS a LEFT JOIN movies_additional_details AS b ON a.id = b.id WHERE a.id = '{$movie_id}'")->fetchAll();
        if (count($query) > 0) {
            $movie = $query[0];
            $arr = [];
            foreach (explode(", ", $movie["production_companies"]) as $item) $arr[] = $db->query("SELECT * FROM production_companies WHERE id = '{$item}'")->fetchAll()[0];
            $movie["production_companies"] = $arr;
            return json_encode($movie);
        }
        
    }

    print_r(getSelectedMovie());

?>