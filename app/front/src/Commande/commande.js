import React, {useState, useEffect} from 'react';
import { useWaitFor } from "../shared/hooks";
import {get_all_product} from '../api';
import './style/commande.css';





export default function Commande(){
  const [token, setToken] = useState(false);
  const [result, setResult] = useState([])

  useWaitFor(
    () => get_all_product(),
    [],
    (res) => {
      setResult(res['hydra:member']);
    }
  );

  useEffect(() => {
    setResult(result);
    console.log('res', result);
  }, [result]);

  return (
    <>
      <h1>Commande</h1>
      <div className="produits">
        {
          result.map(item => {
            return(
              <div className="item-card">
                <p>{item['title']}</p>
                <p>{item['quantity']}</p>
                <p>{item['price']} €</p>
                <p>{item['description']}</p>
              </div>
            )
          })
        }
      </div>
    </>
  )
}
