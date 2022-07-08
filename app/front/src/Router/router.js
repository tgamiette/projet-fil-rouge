import React, {useState, useEffect} from 'react';
import '../index.css';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import NeedAuth from '../Components/Auth/needAuth'
import App from "../Main/App";
import Nav from "../Main/Nav";
import Maps from "../Map/map";
import Calendrier from "../Calendrier/calendrier";
import Producteurs from "../Producteurs/producteurs";
import ProducteurSingle from "../Producteurs/producteur_single";
import Login from "../Main/login";
import Account from "../Accounts/account";
import Parametres from "../Accounts/parametres";
import FormProduits from "../Accounts/formProduits";
import Products from "../Accounts/products";
import SignIn from "../Main/signIn";
import ProduitSingle from "../Produits/produitSingle";
import Produits from "../Produits/produits";
import Panier from "../Panier/panier";
import Stripes from "../Panier/stripes";
import {loggedIn} from "../api";
import { CookiesProvider } from 'react-cookie';
import {useSelector, useDispatch } from 'react-redux';

export default function Router({}){

  const [logged, setLogged] = useState(false);

  useEffect(() => {
    console.log('loggedIN', loggedIn());
    setLogged(logged);
    loggedIn() === true ? setLogged(true) : setLogged(false);
    console.log('logged', logged);
  }, []);

  return(
    <>
      <BrowserRouter>
        <CookiesProvider>
          <Nav logged={logged} setLogged={setLogged}/>
          <Routes>
            <Route path="/" element={<App />} />
            <Route path="/map" element={<Maps />} />
            <Route path="/producteurs" element={<Producteurs />} />
            <Route path="/producteur/:id" element={<ProducteurSingle />} />
            <Route path="/produits/:id" element={<ProduitSingle />} />
            <Route path="/produits" element={<Produits/>} />
            <Route path="/login" element={<Login />} />
            <Route path="/signIn" element={<SignIn />} />

            <Route path="/panier/*">
               <Route index element={<Panier />} />
               <Route path="stripe" element={<Stripes />} />
            </Route>

            <Route path="/calendrier" element={
                  <NeedAuth children={<Calendrier />}></NeedAuth>
            }/>

            <Route path="/account/*">
               <Route index element={<NeedAuth children={<Account />}></NeedAuth>} />
              
               <Route path="parametres" element={<Parametres />} />
               <Route path="produits" element={<Products />} />
               <Route path="produits/ajout" element={<FormProduits />} />
             </Route>
          </Routes>
        </CookiesProvider>
      </BrowserRouter>
    </>
  )
}
