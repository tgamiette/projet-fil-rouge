import React from 'react';
import { Link } from "react-router-dom";
import './style/panier.css';
import {CloseCircle}  from '@styled-icons/evaicons-solid/CloseCircle';
import {useDispatch, useSelector} from "react-redux";
import {selectCart} from "../redux/userCart";

export default function Panier({}){

  const purchases = [1, 2, 3 , 4];
  const dispatch = useDispatch();
  const cart = useSelector(selectCart);


  console.log('cart', cart);

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
            cart.map((item, index) => {
              return(
                <tr className="c-commande_card">
                  <td><span></span> <p>{item.name}</p></td>
                  <td><span>{item.price}</span></td>
                  <td><span>{item.quantity}</span></td>
                  <td><p>{item.quantity * item.price}</p></td>
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
