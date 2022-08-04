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
      if(res !== undefined){
        setProducteur(res);
      }
    }
  );

  return(
    <div className="c-container single">
        <div>
          <h1>Fiche descriptive</h1>
          <div className="c-producteurs">
            <img src="https://images.unsplash.com/photo-1624720114708-0cbd6ee41f4e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1769&q=80" alt="" />
            <div className="c-producteur_info">
              <p>{producteur['fullName']}</p>
              <p>{producteur['description']}</p>
              // <button className="c-btn">Voir tous mes produits</button>
            </div>
          </div>
        </div>

        <div className="c-main_products">
          <h2>Mes produits</h2>
          <div className="c-products_row">
          {
            producteur !== false && producteur['products'].length !== 0?
              producteur['products'].map((item) => {
                return(
                  <Link to={`/produits/${item['@id'].charAt(item['@id'].length - 1)}`}>
                    <div className="c-product_card">
                      <span className="c-product_img">
                      <img src={`http://localhost:8000${item.contentUrl}`} alt="Image Produits" />
                      </span>
                      <p>{item['title']}</p>
                    </div>
                  </Link>
                )
              })
            :
            <p>{producteur['fullName']} n'a pas encore ajoutés de produits à la vente !</p>
          }
          </div>
        </div>
    </div>
  )
}
