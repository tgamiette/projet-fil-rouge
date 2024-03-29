import React, {useState, useEffect} from 'react';
import {useWaitFor} from '../shared/hooks';
import { useParams } from "react-router-dom";
import {get_product, get_product_by_category} from '../api';
import { Link } from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {addCart} from "../redux/userCart";
import {selectCart} from "../redux/userCart";
import {selectUser} from "../redux/userSlice";
import { CircularProgressbar } from 'react-circular-progressbar';
import 'react-circular-progressbar/dist/styles.css';
import './style/produit.css'


export default function ProduitSingle({}){

  const {id} = useParams();
  const [product, setProduct] = useState(false);
  const [category, setCategory] = useState(false);
  const [active, setActive] = useState(false);
  const dispatch = useDispatch();
  const cart = useSelector(selectCart);
  const user = useSelector(selectUser);

  const objective = Math.floor(Math.random() * (300 - 105) + 105);

  useWaitFor(
    () => get_product(id),[id],(res) => {
      setProduct(res);

      console.log('res', res);
    }
  );
  //
  // useWaitFor(
  //   () => get_product_by_category(product.category['@id'].substring(product.category['@id'].lastIndexOf('/') + 1)),[product],(res) => {
  //     console.log(product.category['@id'].substring(product.category['@id'].lastIndexOf('/') + 1));
  //
  //     if(res!== undefined){
  //       setCategory(res['hydra:member']);
  //       console.log('cat', res['hydra:member']);
  //     }
  //   }
  // );

  const handleProduct = (e) => {
    e.preventDefault();
    dispatch(addCart({
      id: product['@id'],
      name: product['title'],
      quantity: e.target.quantity.value,
      price: product['price']
    }));

    setActive(true);
  }

  return(

    <div className="c-produits c-container_app">
      <div className="c-produits_infos">
        <div className="card">
          <h2>{product.title}</h2>
          <div className="c-produit_single">
            <div className="c-produit_img">
              <div className="c-img_circle">
                <CircularProgressbar value={(product.quantity* 100 )/product.objective}/>
                <img className="c-img_produit" src={`http://localhost:8000${product.contentUrl}`} alt="" />
              </div>
              <div className="c-product_number">
                <span>{product.quantity}kg restant</span>
                <span>{product.objective}kg disponible</span>
              </div>
            </div>
            <div className="c-produit_infos">
              <span>{product.price} € le kilos</span>
              <span>Vendu par {}</span>
              <p>{product.description} </p>
              <Link to={`/producteur/1`} className="c-btn">Voir le producteur</Link>
            </div>
          </div>
        </div>

        <div className="c-produit_other">
          <h2>Nos autres produits</h2>
          <div className="c-other">
            {
              category !== false ?
                category.map((item, index) => {
                  if(index < 4){
                    return(
                      <Link to={`/produits/${index}`} >
                        <div className="c-produit_img">
                          <div className="c-img_circle_2">
                            <CircularProgressbar value={Math.floor(Math.random() * (100 - 0) + 0)} />
                            <img className="c-img_produit" src={`http://localhost:8000${item.contentUrl}`}  alt="" />
                          </div>
                          <span>{item['title']}</span>
                        </div>
                      </Link>
                    )
                  }
                })
              :
              null
            }
          </div>
        </div>
      </div>


      <div className="c-produit_add card">
      {
        user !== null ?
          <>
            <h3>Vous souhaitez ajouter ce produits à votre panier ?</h3>
            <form onSubmit={handleProduct}>
              <input type="text" name="nom" placeholder="Nom"/>
              <input type="text" name="prenom" placeholder="Prénom"/>
              <input type="number" name="quantity" min="1" max={product['quantity']} placeholder="Quantité"/>
              <button type="button" type="submit" className="c-btn">Ajouter au panier</button>
            </form>
          </>
        :
        <>
          <h3>Vous devez être connecter pour pouvoir commander se produits </h3>
          <Link to={`/login`} className="c-btn">Me connecter</Link>

        </>
      }

      </div>

      <div className={`c-popup_bg ${active ? "active" : ""}`}>
        <div className="c-popup_buy">
          <h2>Vous venez d'ajouter</h2>
          <div className="c-infos">
            <p><span>Nom:</span> {product['title']}</p>
            <p><span>Quantité:</span> 6</p>
            <p><span>Prix:</span> {product['price']}/kg</p>
          </div>
          <div className="c-btn_grp">
            <button type="button" className="c-btn" onClick={() => setActive(false)}>Continuer mes achats</button>
            <Link to={`/panier`} className="c-btn">Voir mon panier</Link>
          </div>
        </div>
      </div>
    </div>
  )
}
