import React, {useState} from 'react';
import {useWaitFor} from '../shared/hooks';
import {get_product_by_seller} from "../api";
import {useSelector} from "react-redux";
import {selectUser} from "../redux/userSlice";
import SubNav from './nav';
import { Link } from "react-router-dom";

export default function Products({}){

  const [products, setProducts] = useState(false);
  const user = useSelector(selectUser);

  useWaitFor(
    () => get_product_by_seller(user.id),[user],(res) => {
      setProducts(res['hydra:member']);
      console.log('res', res);
    }
  );



  return(
    <div className="c-account">
      <SubNav />
      <div>
        <h1>Mes produits</h1>
        <div>
          {
            products.length !== 0 && products !== false && products !== undefined ?
              <table>
                <thead>
                  <td>Nom</td>
                  <td>Prix</td>
                  <td>Quantité</td>
                  <td>Objectif</td>
                  <td>Categorie</td>
                  <td></td>
                </thead>
                <tbody>
                {
                  products.map((item,index) => {
                    return(
                      <tr>
                        <td className="c-first">
                          <img className="c-account_img" src={`http://localhost:8000${item.contentUrl}`} alt="" />
                            {item.title}
                        </td>
                        <td>{item.price}€/kg</td>
                        <td>{item.quantity} kg</td>
                        <td>{item.objective} kg</td>
                        <td>{item.category.title}</td>
                        <td>
                          <Link to={`/produits/${item.id}`} className="c-btn">Voir le produit</Link>
                        </td>
                      </tr>
                    )
                  })
                }
                </tbody>
              </table>
            :
            <p>Vous n'avez encore ajouter aucun produits à votre liste !</p>
          }
        </div>
      </div>

    </div>
  )
}
