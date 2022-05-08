import React, {useState, useEffect} from 'react';
import logo from './logo.svg';
import { Link } from "react-router-dom";
import './style/Nav.css'
import {getToken, unsetToken} from '../api';
import {ShoppingBasket} from '@styled-icons/remix-line/ShoppingBasket';


export default function Nav(){

  const [isLogged, setIsLogged] = useState(false);

  useEffect(() => {
    getToken() === "undefined" ? setIsLogged(false) : setIsLogged(true);
    console.log(isLogged);
  }, []);

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
            isLogged ?
              <>
              <a onClick={() => { setIsLogged(false); unsetToken();}}>Logout</a>
              <Link to="/panier"><ShoppingBasket size="50"/></Link>
              </>
            :
            <Link to="/login">Login</Link>
          }

        </ul>
      </nav>
    </header>
  )
}
