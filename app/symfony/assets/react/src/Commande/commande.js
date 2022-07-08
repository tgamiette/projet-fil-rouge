import React, {useState, useEffect} from 'react';
import { useWaitFor } from "../shared/hooks";
import {get_all_product} from '../api';
import './style/commande.css';
import { CircularProgressbar } from 'react-circular-progressbar';

export default function Commande(){
  const [token, setToken] = useState(false);
  const [result, setResult] = useState([])

  return (
    <div className="c-container_commande">

      <div className="c-commandes">
        <h1>Commande</h1>
        <div className="c-commande_row">
          <span>
            <img src="https://promos-algerie.com/comment-reussir-ses-frites-et-quelles-pomme-de-terres-choisir/" alt="" />
          </span>
          <p>Numéro 3</p>
          <p>6 pers.</p>
          <button type="button">Voir plus</button>
          <CircularProgressbar value={Math.floor(Math.random() * (100 - 0) + 0)} text={`${Math.floor(Math.random() * (100 - 0) + 0)} %`}/>
        </div>
        <div className="c-commande_row">
          <span>
            <img src="https://promos-algerie.com/comment-reussir-ses-frites-et-quelles-pomme-de-terres-choisir/" alt="" />
          </span>
          <p>Numéro 3</p>
          <p>6 pers.</p>
          <button type="button">Voir plus</button>
          <CircularProgressbar value={Math.floor(Math.random() * (100 - 0) + 0)} text={`${Math.floor(Math.random() * (100 - 0) + 0)} %`}/>
        </div>
        <div className="c-commande_row">
          <span>
            <img src="https://promos-algerie.com/comment-reussir-ses-frites-et-quelles-pomme-de-terres-choisir/" alt="" />
          </span>
          <p>Numéro 3</p>
          <p>6 pers.</p>
          <button type="button">Voir plus</button>
          <CircularProgressbar value={Math.floor(Math.random() * (100 - 0) + 0)} text={`${Math.floor(Math.random() * (100 - 0) + 0)} %`}/>
        </div>
      </div>


    </div>
  )
}
