import React, {useEffect} from 'react';
import { Link } from "react-router-dom";
import './style/panier.css';
import {CloseCircle}  from '@styled-icons/evaicons-solid/CloseCircle';
import {useSelector, useDispatch} from "react-redux";
import {selectCart, removeCart} from "../redux/userCart";

export default function Panier({}){

  const cart = useSelector(selectCart);

  const dispatch = useDispatch();
  var cartPrice = 0;const IMG_URL = process.env.REACT_APP_IMG;

  const handleRemove = (id) => {
    dispatch(removeCart({id: id, cart: cart.filter(item => item.id !== id)}));
  }

  useEffect(() => {
    console.log('cart', cart);
  }, [cart]);



  return(
    <div className="c-container">
      <div className="c-commande">
        <h1>Votre panier</h1>
        <div>
          {
            cart !== undefined && cart.length !== 0?
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
                        cartPrice += item.quantity * item.price;
                        return(
                          <tr className="c-commande_card">
                            <td><span></span> <p>{item.name}</p></td>
                            <td><span>{item.price} €/kg</span></td>
                            <td><span>{item.quantity} kg</span></td>
                            <td><p>{item.quantity * item.price} €</p></td>
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
        cart !== undefined && cart.length !== 0?
          <div className="c-commande_card resume">
            <h2>Récapitulatif</h2>
            <p>Total du Panier</p>
            <p>{cartPrice} €</p>

            <Link to={`stripe`} className="c-btn">Procéder au payement</Link>
          </div>
         :
         <div className="c-commande_card resume" style={{display: "flex", flexDirection: "column", justifyContent: "space-between", alignItems: "flex-start"}}>
          <p>Effectuer des achats pour pouvoir procéder au paiements !</p>
          <Link to={`/produits`} className="c-btn" >Voir les produits</Link>
         </div>
      }

    </div>
  )
}
