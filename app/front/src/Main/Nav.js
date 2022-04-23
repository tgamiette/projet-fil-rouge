import React from 'react';
import logo from './logo.svg';
import { Link } from "react-router-dom";
import './style/Nav.css'

export default function Nav(){

  return (
    <header>
      <img src={logo} alt="" />
      <nav>
        <ul>
          <Link to="/commandes">Les commandes</Link>
          <Link to="/producteurs">Nos producteurs</Link>
          <Link to="/map">Carte</Link>
          <Link to="/calendrier">Calendrier</Link>
        </ul>
      </nav>
    </header>
  )
}
