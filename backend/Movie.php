<?php

    class Movie {

        function __construct($data) {
            $movie_categories = ["id", "original_language", "title", "overview", "genres", "release_date", "popularity", "vote_average", "poster_path", "original_title"];
            foreach ($movie_categories as $movie_category) $this->$movie_category = $data[$movie_category];
        }

        function getColumns() {
            return implode(", ", array_keys((array)$this));
        }

        function getValues() {
            return array_values((array)$this);
        }

    }

?>