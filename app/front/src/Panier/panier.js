import React from 'react';
import { Link } from "react-router-dom";

import './style/panier.css';

import {CloseCircle}  from '@styled-icons/evaicons-solid/CloseCircle';

export default function Panier({}){

  const purchases = [1, 2, 3 , 4];

  return(
    <div className="c-container">
      <div className="c-commande">
        <h1 >Le panier</h1>
        <div>
        <table>
          <thead>
            <td>Produit</td>

            <td>Prix unitaire</td>
            <td>Quantité</td>
            <td>Total</td>
            <td>Retirer</td>
          </thead>
          <tbody>
          {
            purchases.map((item, index) => {
              return(
                <tr className="c-commande_card">
                  <td><span></span> <p>Le produit</p></td>
                  <td><span>3€/k</span></td>
                  <td><span>3kg</span></td>
                  <td><p>36€</p></td>
                  <td className="remove"><CloseCircle width="25" fill="red"/></td>
                </tr>
              )
            })
          }
          </tbody>
        </table>

        </div>
      </div>
      <div className="c-commande_card resume">
        <h2>Récapitulatif</h2>
        <p>Total du Panier</p>
        <p>22€</p>

        <Link to={`stripe`} className="c-btn">Procéder au payement</Link>
      </div>


    </div>
  )
}
