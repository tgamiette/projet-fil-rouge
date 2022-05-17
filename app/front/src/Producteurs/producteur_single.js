import React,{useState} from 'react';
import { useParams } from "react-router-dom";
import {useWaitFor} from '../shared/hooks';
import {get_product, get_producteur} from '../api';
import { Link } from "react-router-dom";



export default function ProducteurSingle({}){

  const [producteur, setProducteur] = useState(false);


  const {id} = useParams();

  useWaitFor(
    () => get_producteur(id),[],(res) => {
      console.log('res', res);
      setProducteur(res);
    }
  );


  return(
    <>
    <h1>Fiche descriptive</h1>
      <div className="c-producteur">
        <img src="" alt="" />
        <div className="c-producteur_info">
          <p>{producteur['fullName']}</p>
          <p>{producteur['description']}</p>
          <button className="c-btn">Voir tous mes produits</button>
        </div>
      </div>

      <div className="c-main_products">
        {
          producteur['products'] !== undefined ?
            producteur['products'].map((item) => {
              return(
                <>
                  <div className="c-product_card">
                    <span className="c-product_img">
                      <img src="" alt="" />
                    </span>
                    <p>{item['title']}</p>
                  </div>
                </>
              )
            })
          :
          null
        }
      </div>

    </>
  )
}
