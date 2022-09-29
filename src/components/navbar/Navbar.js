import React from 'react';
import './navbar.css';

const Navbar = () => {
  return (
    <div id = "navbar-menu">
        <div className="navbar-menu__item"><a href = "/">Top Movies</a></div>
        <div className="navbar-menu__item"><a href = "/genres">Genres</a></div>
        <div className="navbar-menu__item"><a href = "/wordcloud">Wordcloud</a></div>
        <div className="navbar-menu__item"><a href = "/stats">Stats</a></div>
    </div>
  )
}

export default Navbar