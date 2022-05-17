import React, {useState} from 'react';
import SubNav from './nav'
import {get_order_user} from '../api';
import {useWaitFor} from '../shared/hooks';
import './style/account.css';

export default function Commandes({}){

  const [orders, setOrders] = useState(false);

  useWaitFor(
    () => get_order_user(3),[],(res) => {
      console.log('res', res);
      setOrders(res);
    }
  );


  return(
    <div className="c-account">
      <SubNav />
      <div>
        <h1>Mes commandes</h1>
        <table className="c-orders">
          <thead>
            <td>ID</td>
            <td>Numéro de la commande </td>
            <td>Moyen de Payement</td>
            <td>Coût</td>
            <td></td>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>n°2</td>
              <td>Paypal</td>
              <td>58.89€</td>
              <td><button type="button">Voir commande global</button></td>
            </tr>

            <tr>
              <td>1</td>
              <td>n°2</td>
              <td>Paypal</td>
              <td>58.89€</td>
              <td><button type="button">Voir commande global</button></td>
            </tr>

            <tr>
              <td>1</td>
              <td>n°2</td>
              <td>Paypal</td>
              <td>58.89€</td>
              <td><button type="button">Voir commande global</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  )
}
