<?php

    require_once("api_keys.php");
    require_once("Movie.php");
    require_once("TopMovie.php");
    require_once("Database.php");
    define("GENRES_URL", "https://api.themoviedb.org/3/genre/movie/list?api_key=" . getenv("API_KEY") . "&language=en-US");
    define("MOVIES_URL", "https://api.themoviedb.org/3/movie/top_rated?api_key=" . getenv("API_KEY") . "&language=en-US");
    define("IMAGES_PATH", "https://image.tmdb.org/t/p/original/");
    $db = new db();

    function jsonp_decode($jsonp, $assoc = false) {
        if($jsonp[0] !== '[' && $jsonp[0] !== '{') {
           $jsonp = substr($jsonp, strpos($jsonp, '('));
        }
        return json_decode(trim($jsonp,'();'), $assoc);
    }

    function getGenres() {
        $genres = jsonp_decode(getURL(GENRES_URL), true)["genres"];
        foreach ($genres as $genre) {
            if ($genre["name"] == "Documentary") { 
                unset($genres[array_search($genre, $genres)]);
                $genres = array_values($genres); 
            }
        }
        return $genres;
    }

    function getURL($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function getGenresForMovie($genre_ids) {
        $genres_for_movie = [];
        foreach ($genre_ids as $genre_id) {
            global $genres;
            $movie_genres = array_column($genres, "name", "id");
            $genres_for_movie[] = $movie_genres[$genre_id];
        }
        return implode(", ", $genres_for_movie);
    }

    function getTopMovies() {
        global $db;
        foreach (range(1, 23) as $i) {
            $top_movies = jsonp_decode(getURL(MOVIES_URL . "&page=" . $i), true)["results"];
            foreach ($top_movies as $top_movie) {
                $top_movie["genres"] = getGenresForMovie($top_movie["genre_ids"]);
                $top_movie["release_date"] = substr($top_movie["release_date"], 0, 4);
                $top_movie["poster_path"] = IMAGES_PATH . $top_movie["poster_path"];
                $movie = new Movie($top_movie);
                //$query = "INSERT INTO movies ({$movie->getColumns()}) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                //$db->query($query, $movie->getValues());
                $top = getMovie($top_movie["id"]);
                $top->backdrop_path = IMAGES_PATH . $top->backdrop_path;
                $top = new TopMovie($top);
                //print_r($top);
                //foreach ($top->production_companies as $company) print_r($company);
                //print_r($top->production_companies);
                foreach ($top->production_companies as $production_company) {
                    if ($production_company->logo_path != "") $production_company->logo_path = IMAGES_PATH . $production_company->logo_path;
                    $company = new ProductionCompany($production_company);
                    if (count($db->query("SELECT * FROM production_companies WHERE id = '{$company->id}'")->fetchAll()) == 0) {
                        //$query = ("INSERT INTO production_companies ({$company->getColumns()}) VALUES (?, ?, ?, ?)");
                        //$db->query($query, $company->getValues());
                    };
                }
                $top->production_companies = getProductionCompanies($top);
                $top->production_countries = getProductionCountries($top);
                //$query = "INSERT INTO movies_additional_details ({$top->getColumns()}) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                //$db->query($query, $top->getValues());
            }
        }
    }

    function getProductionCompanies($movie) {
        $production_companies = "";
        $movie->production_companies = json_decode(json_encode($movie->production_companies), true);
        $movie->production_countries = json_decode(json_encode($movie->production_countries), true);
        foreach ($movie->production_companies as $production_company) {
            $production_companies .= $production_company["id"];
            if ($production_company != end($movie->production_companies)) $production_companies .= ", ";
        }
        return $production_companies;
    }

    function getProductionCountries($movie) {
        $production_countries = "";
        foreach ($movie->production_countries as $production_country) {
            $production_countries .= $production_country["iso_3166_1"];
            if ($production_country != end($movie->production_countries)) $production_countries .= ", ";
        }
        return $production_countries;
    }

    function getTopMoviesByGenre($genre) {
        global $db;
        $query = $db->query("SELECT * FROM movies WHERE genres REGEXP '{$genre}'")->fetchAll();
        return json_encode($query);
    }
    
    function getMovie($id) {
        global $db;
        $url = "https://api.themoviedb.org/3/movie/{$id}?api_key=" . getenv("API_KEY") . "&language=en-US";
        $movie = jsonp_decode(getURL($url));
        return $movie;
    }

    $genres = getGenres();
    //$top_movies = getTopMovies();
    

?>