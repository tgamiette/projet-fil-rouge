import React, {useState, useEffect} from 'react';
import {useWaitFor} from '../shared/hooks';
import { useParams } from "react-router-dom";
import {get_product, get_all_categories} from '../api';
import { Link } from "react-router-dom";
import { CircularProgressbar } from 'react-circular-progressbar';
import 'react-circular-progressbar/dist/styles.css';

import './style/produit.css'


export default function Produits({}){

  const {id} = useParams();
  const [product, setProduct] = useState(false);
  const [category, setCategory] = useState(false);

  const objective = Math.floor(Math.random() * (300 - 105) + 105);

  useWaitFor(
    () => get_product(id),[id],(res) => {
      setProduct(res);
      console.log('res', res);
    }
  );

  useWaitFor(
    () => get_all_categories(),[id],(res) => {
      setCategory(res['hydra:member']);
      console.log('cat', res['hydra:member']);
    }
  );

  return(

    <div className="c-produits">
      <div className="c-produit_add">
        <form action="">
          <input type="number" name="quantity" min="1" max={product['quantity']} placeholder="Quantité"/>

          <select placeholder="Unité">
            <option value="1">kg</option>
            <option value="2">g</option>
            <option value="3">L</option>
            <option value="4">cl</option>
          </select>
          <input type="text" name="nom" placeholder="Nom"/>
          <input type="text" name="prenom" placeholder="Prénom"/>
          <button type="button" type="submit" className="c-btn">Ajouter</button>
        </form>

      </div>

      <div className="c-produits_infos">
        <div>
          <h2>{product['title']}</h2>
          <div className="c-produit_single">
            <div className="c-produit_img">
              <div className="c-img_circle">
                <CircularProgressbar value={(product['quantity']* 100 )/objective} />
                <img className="c-img_produit" src="https://static.greenweez.com/images/products/127000/600/fruits-legumes-du-marche-bio-pomme-regal-you-candine.jpg" alt="" />
              </div>
              <span>{product['quantity']}kg restant</span>
              <span>{objective}kg disponible</span>
            </div>
            <div className="c-produit_infos">
              <span>{product['price']} € le kilos</span>
              <span>Vendu par {}</span>
              <p>{product['description']} </p>
              <Link to={`/producteur/1`} className="c-btn">Voir le producteur</Link>
            </div>
          </div>
        </div>

        <div className="c-produit_other">
          <h2>Nos autres produits</h2>
          {
            category !== false ?
              category.map((item, index) => {
                if(index < 5){
                  return(
                    <Link to={`/produits/${index}`} >
                      <div className="c-produit_img">
                        <div className="c-img_circle">
                          <CircularProgressbar value={Math.floor(Math.random() * (100 - 0) + 0)} />
                          <img className="c-img_produit" src="https://static.greenweez.com/images/products/127000/600/fruits-legumes-du-marche-bio-pomme-regal-you-candine.jpg" alt="" />
                        </div>
                        <span>{item['title']}</span>
                      </div>
                    </Link>
                  )
                }
              })
            :
            null
          }
        </div>
      </div>
    </div>
  )
}