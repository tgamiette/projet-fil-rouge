import React, {useState} from 'react';
import { useWaitFor } from "../shared/hooks";
import {get_all_product} from '../api';
import './style/commande.css';


export default function Commande(){
  const [token, setToken] = useState(false);

  useWaitFor(
    () => get_all_product(),
    [],
    (res) => {
      console.log('products', res);

    }
  );

  return (
    <h1>Commande</h1>
  )
}
