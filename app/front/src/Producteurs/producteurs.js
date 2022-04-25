import React, {useState} from 'react';
import { Link } from "react-router-dom";
import './style/producteur.css';

export default function Producteurs(){

  const [search , setSearch] = useState("");

  const users = ["user1", "user2", "user3", "user4", "user5", "user5", "user5"];

  const handleSearch = (event) => {
    setSearch(event);
  }

  return(
    <>
      <div className="c-producteurs">
        <div className="c-filter">
          <h2>Filtres</h2>
          <div className="c-filter_input search">
            <label>Recherche</label>
            <input type="search" name="search" value={search} onChange={(e) => handleSearch(e.target.value)}/>
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

        <div className="c-producteur_div">
          <h1>Nos producteurs</h1>
          {
            users.map((item, index) => {
              return(
                <>
                  <div className="c-card_producteur">
                    <span className="c-producteur_img">
                      <img src="" alt="" />
                    </span>
                    <div className="c-producteur_infos">
                      <h2>Marcel Champs</h2>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla lorem est, eu imperdiet lectus pretium sed.</p>
                      <Link to={`/producteur/${index}`} className="c-btn">Découvrir</Link>
                    </div>
                  </div>
                </>
              )
            })
          }
        </div>
      </div>
    </>
  )
}
