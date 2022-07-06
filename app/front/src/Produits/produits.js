import React, {useState} from 'react';
import {get_all_product} from '../api';
import { Link } from "react-router-dom";
import SearchBar from '../Components/SearchBar/searchBar'
import {useWaitFor} from '../shared/hooks';

export default function Produits({}){

  const [produits, setProduits] = useState([]);
  const [filterDisplay, setFilterDisplay] = useState(false);
  const [search ,setSearch] = useState("");


  useWaitFor(
    () => get_all_product(),[],(res) => {
      console.log('res', res['hydra:member']);
      if(res !== undefined){
        setProduits(res['hydra:member']);
        setFilterDisplay(res['hydra:member']);
      }

    }
  );

  return(
    <div className="c-container_items">
      <div>
        <h1>Tout les produits</h1>
        <div className="c-container_products">
        {
          filterDisplay !== false ?
            filterDisplay.map((item, index) => {
              return(
                <div className="c-product_card">
                  <img src={`http://localhost:8000${item.contentUrl}`} alt="Image Produits" />
                  <div>
                    <p>{item.title}</p>
                    <span>Vendu par {item.seller.fullName}</span>
                  </div>
                  <div className="c-container_bottom">
                    <p>{item.price}€/kg</p>
                    <Link to={`/produits/${item.id}`} className="c-btn">Voir le produits</Link>
                  </div>
                </div>
              )
            })
          : "rien"
        }
        </div>
      </div>


      <div>
        <div className="c-filter">
          <h2>Filtres</h2>
          <div className="c-filter_input search">
            <SearchBar dataList={produits} setFilterDisplay={setFilterDisplay}/>
          </div>
          <div className="c-filter_input">
            <label>Trier par proximité</label>
            <input type="radio" name="kilometer" value="5"  placeholder=""/>
            <input type="radio" name="kilometer" value="10" />
            <input type="radio" name="kilometer" value="20" />
            <input type="radio" name="kilometer" value="40" />
            <input type="radio" name="kilometer" value="50" />
          </div>
          <div className="c-filter_input">
            <label>Trier par produits</label>
            <input type="radio" name="" value="" />
          </div>
        </div>
      </div>

    </div>
  )
}
