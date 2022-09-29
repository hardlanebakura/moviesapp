<?php 

    require_once("Database.php");
    require_once("movies_database.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    header('Content-Type: application/json');

    $genre = json_decode(file_get_contents('php://input'), true);
    print_r(getTopMoviesByGenre($genre));

?>