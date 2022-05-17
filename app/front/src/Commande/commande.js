import React, {useState, useEffect} from 'react';
import { useWaitFor } from "../shared/hooks";
import {get_all_product} from '../api';
import './style/commande.css';

export default function Commande(){
  const [token, setToken] = useState(false);
  const [result, setResult] = useState([])

  return (
    <>
      <h1>Commande</h1>
      <div className="produits">

      </div>
    </>
  )
}
