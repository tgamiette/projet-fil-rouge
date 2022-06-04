import {useState, useEffect} from 'react';
import '../index.css';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import NeedAuth from '../Components/Auth/needAuth'
import App from "../Main/App";
import Nav from "../Main/Nav";
import Maps from "../Map/map";
import Calendrier from "../Calendrier/calendrier";
import Producteurs from "../Producteurs/producteurs";
import ProducteurSingle from "../Producteurs/producteur_single";
import Commande from "../Commande/commande";
import Login from "../Main/login";
import Account from "../Accounts/account";
import Parametres from "../Accounts/parametres";
import Commandes from "../Accounts/commandes";
import SignIn from "../Main/signIn";
import Produits from "../Produits/produits";
import Panier from "../Panier/panier";
import Stripes from "../Panier/stripes";
import {loggedIn} from "../api";
import { CookiesProvider } from 'react-cookie';

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
            <Route path="/commandes" element={<Commande />} />
            <Route path="/producteurs" element={<Producteurs />} />
            <Route path="/producteur/:id" element={<ProducteurSingle />} />
            <Route path="/produits/:id" element={<Produits />} />
            <Route path="/login" element={<Login />} />
            <Route path="/signIn" element={<SignIn />} />

            <Route path="/panier/*">
               <Route index element={<Panier />} />
               <Route path="stripe" element={<Stripes />} />
            </Route>
            <Route path="/commandes" element={
                  <NeedAuth logged={logged} children={<Commande />}></NeedAuth>
            }/>
            <Route path="/calendrier" element={
                  <NeedAuth logged={logged} children={<Calendrier />}></NeedAuth>
            }/>

            <Route path="/account/*">
               <Route index element={<NeedAuth logged={logged} children={<Account />}></NeedAuth>} />
               <Route path="commandes" element={<Commandes />} />
               <Route path="paiement" element={<Parametres />} />
               <Route path="parametres" element={<Parametres />} />
             </Route>
          </Routes>
        </CookiesProvider>
      </BrowserRouter>
    </>
  )
}
