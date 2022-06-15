import React from 'react'
import logo from './logo.svg';
import './style/App.css';
import { Link } from "react-router-dom";

function App() {
  return (
    <div className="App">

      <h1>Qui sommes-nous ?</h1>
      <div>
        <div>
          <img src="" alt="" />
          <Link to={`/producteur`} className="c-btn">Voir tous les producteurs</Link>
        </div>

        <div>
          <p>Face à l’inflation et au réchaffement climatique nous avons décidé d’agir et de mettre en place un market place qui permet à tout le monde d’accéder à des produits frais, locaux et BIO en circuit cours en passant directement par les producteurs. </p>
          <span>Achetez en commun c’est acheter malin !</span>
          <img src="" alt="" />
        </div>
      </div>

      <div className="c-background_img"></div>

      <div>
        <span>Bientôt plus disponibles</span>

        <div>
          products
        </div>
        <Link to={`/producteur`} className="c-btn">Passer une commande</Link>
      </div>
    </div>
  );
}

export default App;
