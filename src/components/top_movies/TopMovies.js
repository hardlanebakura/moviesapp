import axios from 'axios';
import React, { useState, useEffect } from 'react';
import { useSearchParams } from 'react-router-dom';
import './top_movies.css';
import star from '../images/star.jpg';

const TopMovies = ({ randomGenre, genres }) => {
  
  console.log(genres);
  genres = genres.map(genre => genre.name);

  const [params] = useSearchParams();

  var [randomGenre, setRandomGenre] = useState(params.get("genre") !== null ? params.get("genre") : randomGenre);
  var [moviesInRandomGenre, setMoviesInRandomGenre] = useState([]);

  const getMoviesForChosenGenre = () => {
        axios({
          method: "post",
          url: "http://localhost/moviesintheatres/backend/api_genres.php",
          headers: { "content-type": "application/json" },
          data: randomGenre
        })
        .then(result => result.data)
        .then(result => { console.log(result); setMoviesInRandomGenre(result.splice(0, 20)); })
        .catch(error => console.log(error));
  }

  const addSelectedOptionRandomGenre = (e) => {
    if (e !== undefined) setRandomGenre(e.target.value);
  }

  const getRows = () => {
    console.log(moviesInRandomGenre);
    const chunk = (arr, size) =>
    Array.from({ length: Math.ceil(arr.length / size) }, (v, i) =>
        arr.slice(i * size, i * size + size)
    );
    const movieRows = chunk(moviesInRandomGenre, 3);
    const getRow = (row) => {
      return row.map((item, index) => {
        return (
          <div className="wrapper">
            <div className="movie">
              <a href = { "/movies/" + item.id } >
                <div className="image-zoom">
                  <img alt = "" src = { item.poster_path } />
                </div>
                <div className="movie-title">{ item.title }</div>
                <div className="movie-rating">
                  <img src = { star } />
                  <div className="movie-rating__votes">{ item.vote_average }</div>
                </div>
                <div className="movie-date">{ item.release_date }</div>
                <div className="movie-genres">
                  { item.genres.split(", ").map(genre => {
                    return (
                      <div>{ genre }</div>
                    )
                  }) }
                </div>
              </a>
            </div>
          </div>
        )
      })
    }
    return movieRows.map((row, index) => {
      return (
        <div className="movie-row" key = { index } >
          { getRow(row) }
        </div>
      )
    })
  }

  useEffect(() => {
    addSelectedOptionRandomGenre();
    getMoviesForChosenGenre();
  }, [randomGenre]);

  return (
    <div id="genres">
        <div id="categories-selection">
            <div>Select a genre:</div>
            <select id = "categories" name = "categories" onChange = { addSelectedOptionRandomGenre } value = { randomGenre } >
                { genres.map((genre, index) => {
                  return (
                    <option key = { index } value = { genre } name = { genre } >{ genre }</option>
                  )
                }) }
            </select>
        </div>
        <div className="movies-rows">
          { getRows() }
        </div>
    </div>
  )
}

export default TopMovies;