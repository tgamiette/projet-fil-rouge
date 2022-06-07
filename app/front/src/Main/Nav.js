import React, {useState, useEffect} from 'react';
import logo from '../assets/images/logo_bioz.png';
import { Link } from "react-router-dom";
import './style/Nav.css'
import {getCookie, eraseCookie} from '../api';
import {ShoppingBasket} from '@styled-icons/remix-line/ShoppingBasket';
import {AccountCircle} from '@styled-icons/material-sharp/AccountCircle';


export default function Nav({logged, setLogged}){

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
          {
            logged ?
              <>
                <a onClick={() => { setLogged(false); eraseCookie('user_token');eraseCookie('user_role');}}>Logout</a>
                <Link to="/panier"><ShoppingBasket size="40"/></Link>
                <Link to="/account"><AccountCircle size="40"/></Link>
              </>
            :
            <Link to="/login">Login</Link>
          }

        </ul>
      </nav>
    </header>
  )
}
