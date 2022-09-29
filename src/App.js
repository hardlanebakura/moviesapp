import React, { useState, useEffect } from 'react';
import { Routes, Route, Outlet } from 'react-router-dom';
import './index.css';
import { Navbar, TopMovies, Genres, Stats, Footer, Movie } from './components';
import './App.css';
import axios from 'axios';

function App() {

  const [data, setData] = useState({});
  const [randomGenre, setRandomGenre] = useState("");
  const [genres, setGenres] = useState([]);

  const getData = () => {
    axios.get("http://localhost/moviesintheatres/backend/api_movies.php")
    .then(response => response.data)
    .then(response => { console.log(response); setData(response); setGenres(response.genres); getChosenCategory(response) })
    .catch(error => console.log(error));
  }

  const getChosenCategory = (data) => {
    setRandomGenre(data.genres[Math.floor(Math.random() * data.genres.length)].name);
  }

  useEffect(() => {
    getData();
  }, []);

  if (Object.keys(data).length > 0 && randomGenre !== "") return (
    <Routes>
      <Route path = "/" element = {<Layout />} >
        <Route path = "/" element = {<TopMovies randomGenre = { randomGenre } genres = { genres } />} />
        <Route path = "/stats" element = {<Stats />} />
        <Route path = "/movies/:id" element = {<Movie />} />
      </Route>
    </Routes>
  );
}

function Layout () {
  return (
    <>
      <Navbar />
      <Outlet />
      <Footer />
    </>
  )
}

export default App;

