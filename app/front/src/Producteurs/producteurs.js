import React, {useState} from 'react';
import { Link } from "react-router-dom";
import {useWaitFor} from '../shared/hooks';
import {get_all_producteurs} from '../api';
import SearchBar from '../Components/SearchBar/searchBar'

import './style/producteur.css';


export default function Producteurs(){

  const [producteurs, setProducteurs] = useState([]);
  const [filterDisplay, setFilterDisplay] = useState(false);
  const [search , setSearch] = useState("");


  useWaitFor(
    () => get_all_producteurs(),[],(res) => {
      console.log('res', res['hydra:member']);
      if(res !== undefined){
        setProducteurs(res['hydra:member']);
        setFilterDisplay(res['hydra:member']);
      }

    }
  );

  return(
    <div className="c-container">
      <div className="c-producteurs">
        <div>
          <div className="c-filter">
            <h2>Filtres</h2>
            <div className="c-filter_input search">
              <SearchBar dataList={producteurs} setFilterDisplay={setFilterDisplay}/>
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

        <div className="c-producteur_div">
          <h1>Nos producteurs</h1>
          {
            filterDisplay !== false ?
              filterDisplay.map((item, index) => {
                console.log(item["roles"][0]);
                return(
                  <>
                  {
                    item["roles"][0] === 'ROLE_SELLER' ?
                    <div className="c-card_producteur">
                      <span className="c-producteur_img">
                        <img src="https://icons-for-free.com/download-icon-man+person+profile+user+worker+icon-1320190557331309792_512.png" alt="" />
                      </span>
                      <div className="c-producteur_infos">
                        <h2>{item['fullName']}</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla lorem est, eu imperdiet lectus pretium sed.</p>
                        <Link to={`/producteur/${item['id']}`} className="c-btn">Découvrir</Link>
                      </div>
                    </div>
                    :
                    null
                  }
                  </>
                )
              })
            :
            null
        }
        </div>
      </div>
    </div>
  )
}
