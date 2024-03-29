import React, {useState, useEffect} from 'react';
import {get_all_product, get_all_categories, get_product_by_category} from '../api';
import { Link } from "react-router-dom";
import SearchBar from '../Components/SearchBar/searchBar'
import {useWaitFor} from '../shared/hooks';

export default function Produits({}){

  const [produits, setProduits] = useState([]);
  const [category, setCategory] = useState(false);
  const [filterDisplay, setFilterDisplay] = useState(false);
  const [search ,setSearch] = useState("");
  const [catSearch ,setCatSearch] = useState(false);
  const [pagination, setPagination] = useState(false);

  const [pageArr, setPageArr] = useState([]);
  const [pageNb, setPageNb] = useState(1);

  const IMG_URL = process.env.REACT_APP_IMG;

  useWaitFor(
    () => get_all_product(pageNb),[pageNb],(res) => {
      console.log('res', res['hydra:member']);
      if(res !== undefined){
        setProduits(res['hydra:member']);
        setFilterDisplay(res['hydra:member']);
        setPagination(res['hydra:view']);
        setPageArr([]);

      }
    }
  );

  useEffect(() => {
    setPageArr([]);
    if(pagination.length !== 0 && pagination !== false){
      for (var i = parseInt(pagination['hydra:first'].slice(-1)); i <= parseInt(pagination['hydra:last'].slice(-1)); i++) {
        setPageArr((pageArr) => [...pageArr, "item"]);
      }
    }
  }, [pagination]);

  useWaitFor(
    () => get_product_by_category(catSearch),[catSearch],(res) => {
      if(res !== undefined){
        setFilterDisplay(res['hydra:member']);
      }
    }
  );

  useWaitFor(
    () => get_all_categories(),[],(res) => {
      setCategory(res['hydra:member']);
    }
  );

  const handleCatSearch = (e) => {
    setCatSearch(e.target.value);
  }

  const handlePagination = (event) => {
    setPageNb(event);
    window.location(0,0);
  }

  return(
      <div className="c-container_items">
        <div>
          <h1>Tout les produits</h1>
          <div className="c-container_products">
          {
            filterDisplay !== false  && filterDisplay.length !== 0 ?
              filterDisplay.map((item, index) => {
                return(
                  <div className="c-product_card">
                    <img src={`${IMG_URL}${item.contentUrl}`} alt="Image Produits" />
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
            :
            <p>Nous n'avons pas trouver de produits correspondant à votre recherche !</p>
          }
          </div>

          <div className="c-pagination">
            {
              pageArr.length !== 0 ?
                <>
                {
                  pageArr.map((item, index) => {
                    console.log(pageArr);
                    return(
                      <p onClick={() => handlePagination(index + 1)} className={pageNb === index + 1 ? "current" : ""}>{index + 1}</p>
                    )
                  })
                }
                </>
              :
              null
            }
          </div>
        </div>


        <div>
          <div className="c-filter">
            <div className="c-row">
              <h2>Filtres</h2>
              <button type="button" onClick={() => setFilterDisplay(produits)}>Effacer</button>
            </div>
            <div className="c-filter_input search">
              <SearchBar dataList={produits} setFilterDisplay={setFilterDisplay} type="produits"/>
            </div>
            <div className="c-filter_input">
              <p>Trier par catégories de produits</p>
              {
                category !== false ?
                <>
                  {
                  category.map((item, index) => {
                    return(
                      <>
                        <label className={item['@id']}>{item.title}</label>
                        <input type="radio" id={item['@id']} name="category" value={item['@id']} onChange={handleCatSearch}/>
                      </>
                    )
                  })
                  }
                </>
                :
                null
              }
            </div>
          </div>
        </div>

      </div>
  )
}
