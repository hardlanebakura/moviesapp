import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import './movie.css';
import axios from 'axios';

const Movie = () => {

  const params = useParams().id;
  const [movie, setMovie] = useState({});

  const getData = () => {
    axios({
      method: "post",
      url: "http://localhost/moviesintheatres/backend/api_movie.php",
      headers: { "content-type": "application/json" },
      data: params
    })
    .then(result => result.data)
    .then(result => { console.log(result); setMovie(result); })
    .catch(error => console.log(error));
  }

  useEffect(() => {
    getData();
  }, []);

  if (Object.keys(movie).length > 0) return (
    <div id = "movie">
      <div id="movie-wallpaper">
        <img alt = "" src = { movie.backdrop_path } />
      </div>
      <div id="movie-info">
        <div id="movie-poster">
          <img alt = "" src = { movie.poster_path } />
        </div>
        <div id="movie-details">
          <div id="movie-title">{ movie.title }</div>
          <div id="movie-synopsis">{ movie.overview }</div>
          <div id="movie-genres">
            { movie.genres.split(", ").map((genre, index) => {
              return (
                <>
                <a href = { "/?genre=" + genre }>{ genre }</a>
                <>{ (index !== movie.genres.split(", ").length - 1) ? ", " : null }</>
                </>
              )
            }) }
          </div>
          <div id="movie-popularity" className="movie-detail">
            <div className="movie-detail__name">Popularity rank</div>
            <div className="movie-detail__value">{ movie.popularity }</div>
          </div>
          { movie.budget !== 0 && 
          <div id="movie-budget" className="movie-detail">
            <div className="movie-detail__name">Budget</div>
            <div className="movie-detail__value">{ (movie.budget < 1000) ? movie.budget : (movie.budget < 1000000) ? (movie.budget/1000).toFixed(2) + "K" : (movie.budget % 1000000 === 0) ? Math.floor(movie.budget/1000000) + "M" : (movie.budget/1000000).toFixed(2) + "M" }</div>
          </div> }
          { movie.revenue !== 0 && 
          <div id="movie-revenue" className="movie-detail">
            <div className="movie-detail__name">Revenue</div>
            <div className="movie-detail__value">{ (movie.revenue < 1000) ? movie.revenue : (movie.revenue < 1000000) ? (movie.revenue/1000).toFixed(2) + "K" : (movie.revenue % 1000000 === 0) ? Math.floor(movie.revenue/1000000) + "M" : (movie.revenue/1000000).toFixed(2) + "M" }</div>
          </div> }
          <div id="movie-runtime" className="movie-detail">
            <div className="movie-detail__name">Runtime</div>
            <div className="movie-detail__value">{ (movie.runtime < 60) ? movie.runtime : Math.floor(movie.runtime/60) + "h" + movie.runtime % 60 + "min" }</div>
          </div>
          <div id="movie-year" className="movie-detail">
            <div className="movie-detail__name">Year</div>
            <div className="movie-detail__value">{ movie.release_date }</div>
          </div>
          <div className="movie-detail">
            <div className="movie-detail__name">Production companies</div>
            <div id="movie-companies" className="movie-detail__value">
              { movie.production_companies.map((company, index) => {
                return (
                  company.logo !== null && <div key = { index } className="company">
                    <img alt = "" src = { company.logo } />
                    </div>
                )
              }) }
            </div>
          </div>
          <div id="movie-countries" className="movie-detail">
            <div className="movie-detail__name">Production countries</div>
            <div className="movie-detail__value">{ movie.production_countries.split(", ").map((item, index) => {
              return item;
            }) }</div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default Movie