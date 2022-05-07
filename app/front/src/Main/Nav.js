import React from 'react';
import logo from './logo.svg';
import { Link } from "react-router-dom";
import './style/Nav.css'
// import ShoppingBasket from '@styled-icons/remix-line/ShoppingBasket';


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
        <ul>
          <Link to="/login">Login</Link>
          <Link to="/login">Logout</Link>
          <Link to="/panier"></Link>
        </ul>
      </nav>
    </header>
  )
}
