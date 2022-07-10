import React, {useState, useEffect} from 'react';
import logo from '../assets/images/logo_bioz.png';
import { Link , useNavigate} from "react-router-dom";
import './style/Nav.css'
import {getCookie, eraseCookie} from '../api';
import {ShoppingBasket} from '@styled-icons/remix-line/ShoppingBasket';
import {AccountCircle} from '@styled-icons/material-sharp/AccountCircle';
import {logout} from "../redux/userSlice";
import {useSelector, useDispatch} from 'react-redux';
import {selectUser} from "../redux/userSlice";
import {emptyCart} from "../redux/userCart";


export default function Nav({logged, setLogged}){

  const dispatch = useDispatch();
  const user = useSelector(selectUser);
  const navigate = useNavigate();

  const onLogout = () => {

     eraseCookie('user_token');
     dispatch(logout());
     dispatch(emptyCart());
     window.location.href = "/login";
     console.log('lapin');
  }

  return (
    <header>
      <Link to="/">
        <img src={logo} alt="" />
      </Link>
      <nav>
        <ul>
          <Link to="/">Accueil</Link>
          <Link to="/produits">Les produits</Link>
          <Link to="/producteurs">Nos producteurs</Link>
          <Link to="/map">Carte</Link>
          <Link to="/calendrier">Calendrier</Link>

        </ul>
        <ul>
          {
            user !== null ?
              <>
                <a onClick={onLogout}>Logout</a>
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
