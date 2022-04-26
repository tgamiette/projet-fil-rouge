import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import reportWebVitals from './reportWebVitals';

import App from "./Main/App";
import Nav from "./Main/Nav";
import Map from "./Map/map";
import Calendrier from "./Calendrier/calendrier";
import Producteurs from "./Producteurs/producteurs";
import ProducteurSingle from "./Producteurs/producteur_single";
import Commande from "./Commande/commande";
import Login from "./Main/login";
import Account from "./Accounts/account";
import SignIn from "./Main/signIn";


ReactDOM.render(
  <BrowserRouter>
    <Nav />
    <Routes>
      <Route path="/" element={<App />} />
      <Route path="map" element={<Map />} />
      <Route path="commandes" element={<Commande />} />
      <Route path="producteurs" element={<Producteurs />} />
      <Route path="calendrier" element={<Calendrier />} />
      <Route path="/producteur/:id" element={<ProducteurSingle />} />
      <Route path="/login" element={<Login />} />
      <Route path="/account" element={<Account />} />
      <Route path="/SignIn" element={<SignIn />} />
    </Routes>
  </BrowserRouter>,
  document.getElementById('root')
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
