import React, {useState} from 'react'
import logo from './logo.svg';
import {useWaitFor} from '../shared/hooks';
import {get_all_product} from '../api';
import './style/App.css';
import { Link } from "react-router-dom";
import farmer from '../assets/images/farmer-2.jpg';
import { CircularProgressbar } from 'react-circular-progressbar';
import 'react-circular-progressbar/dist/styles.css';

function App() {

  const [product, setProduct] = useState(false);
  const [filterDisplay, setFilterDisplay] = useState(false);

  useWaitFor(
    () => get_all_product(),[],(res) => {
      if(res !== undefined){
        setProduct(res['hydra:member']);

      }
    }
  );

  console.log(product);



  return (
    <div className="App c-container_app">


      <div className="c-presentation">
        <div>
          <h1>Qui sommes-nous ?</h1>
          <img src={farmer} alt="" />
          <Link to={`/producteur`} className="c-btn">Voir tous les producteurs</Link>
        </div>

        <div>
          <p>Face à l’inflation et au réchaffement climatique nous avons décidé d’agir et de mettre en place un market place qui permet à tout le monde d’accéder à des produits frais, locaux et BIO en circuit cours en passant directement par les producteurs. </p>
          <span>Achetez en commun c’est acheter malin !</span>
          <img src={farmer} alt="Bioz - Illustration de fermier" />
        </div>
      </div>

      <div className="c-background_img"></div>

      <div>
        <h2>Nos nouveaux produits</h2>
        <div className="c-last_product">
        {
          product !== false ?
             product.map((item,index) => {
               if(index < 5){
                 return(
                    <div className="c-produtcs">
                      <span>{item.category.title}</span>
                      <span>{item.title}</span>
                      <img className="" src="https://static.greenweez.com/images/products/127000/600/fruits-legumes-du-marche-bio-pomme-regal-you-candine.jpg" alt="" />
                      <span>Producteurs: {item.seller.fullName}</span>

                      <Link to={`/produits/${item.id}`} className="c-btn">Découvrir</Link>
                    </div>
                 )
               }
             })
           :
           null
          }
        </div>

      </div>
    </div>
  );
}

export default App;
