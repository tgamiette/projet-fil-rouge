import React from 'react';
import { useParams } from "react-router-dom";

export default function ProducteurSingle({}){

  const {id} = useParams();
  
  const products = ["1", "2", "3"];

  return(
    <>
    <h1>Fiche descriptive</h1>
      <div className="c-producteur">
        <img src="" alt="" />
        <div className="c-producteur_info">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla lorem est, eu imperdiet lectus pretium sed</p>
          <button className="c-btn">Voir tous mes produits</button>
        </div>
      </div>

      <div className="c-main_products">
        {
          products.map((item) => {
            return(
              <>
                <div className="c-product_card">
                  <span className="c-product_img">
                    <img src="" alt="" />
                  </span>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla lorem est, eu imperdiet lectus pretium sed.</p>
                </div>
              </>
            )
          })
        }
      </div>

    </>
  )
}
