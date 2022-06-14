import React from 'react';
import { Link } from "react-router-dom";
import './style/panier.css';
import {CloseCircle}  from '@styled-icons/evaicons-solid/CloseCircle';
import {useSelector, useDispatch} from "react-redux";
import {selectCart, removeCart} from "../redux/userCart";

export default function Panier({}){

  const cart = useSelector(selectCart);
  const dispatch = useDispatch();

  console.log('cart', cart);

  const handleRemove = (id) => {
    console.log(id);
    dispatch(removeCart({
      id: id
    }));
    console.log(cart);
  }



  return(
    <div className="c-container">
      <div className="c-commande">
        <h1>Votre panier</h1>
        <div>
          {
            cart.length !== 0 ?
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
                      <td className="remove" onClick={() => handleRemove(item.id)}><CloseCircle width="25" fill="red"/></td>
                    </tr>
                  )
                })
              }
              </tbody>
            </table>
            :
            <p>Vous n'avez aucun produit actuellement dans votre panier !</p>
          }

        </div>
      </div>
      {
        cart.length !== 0 ?
          <div className="c-commande_card resume">
            <h2>Récapitulatif</h2>
            <p>Total du Panier</p>
            <p>22€</p>

            <Link to={`stripe`} className="c-btn">Procéder au payement</Link>
          </div>
         :
         null
      }



    </div>
  )
}
