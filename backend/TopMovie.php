<?php

    class TopMovie {

        function __construct($data) {
            $movie_categories = ["id", "title", "backdrop_path", "budget", "revenue", "runtime", "tagline", "production_companies", "production_countries"];
            foreach ($movie_categories as $movie_category) $this->$movie_category = $data->$movie_category;
        }

        function getColumns() {
            return implode(", ", array_keys((array)$this));
        }

        function getValues() {
            return array_values((array)$this);
        }

    }

    class ProductionCompany {

        function __construct($data) {
            $data = json_decode(json_encode($data), true);
            $maps = array("logo_path"=>"logo", "origin_country"=>"country");
            foreach (array_keys($data) as $k) {
                if (in_array($k, array_keys($maps))) {
                    $data[$maps[$k]] = $data[$k];
                    unset($data[$k]);
                }
            }
            foreach (array_keys($data) as $k) {
                $this->$k = $data[$k];
            }
        }

        function getColumns() {
            return implode(", ", array_keys((array)$this));
        }

        function getValues() {
            return array_values((array)$this);
        }

    }

?>