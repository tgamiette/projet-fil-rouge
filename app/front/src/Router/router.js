import {useState, useEffect} from 'react';
import '../index.css';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import NeedAuth from '../Components/Auth/needAuth'
import App from "../Main/App";
import Nav from "../Main/Nav";
import Map from "../Map/map";
import Calendrier from "../Calendrier/calendrier";
import Producteurs from "../Producteurs/producteurs";
import ProducteurSingle from "../Producteurs/producteur_single";
import Commande from "../Commande/commande";
import Login from "../Main/login";
import Account from "../Accounts/account";
import Parametres from "../Accounts/parametres";
import SignIn from "../Main/signIn";
import {getToken} from "../api";

export default function Router({}){

  const [logged, setLogged] = useState(false);

  useEffect(() => {
    setLogged(logged);
    getToken() === "undefined" ? setLogged(false) : setLogged(true);

    console.log('logged', logged);
  }, [logged]);

  return(
    <>
      <BrowserRouter>
        <Nav logged={logged} setLogged={setLogged}/>
        <Routes>
          <Route path="/" element={<App />} />
          <Route path="/commandes" element={<Commande />} />
          <Route path="/map" element={<Map />} />
          <Route path="/producteurs" element={<Producteurs />} />
          <Route path="/calendrier" element={<Calendrier />} />
          <Route path="/producteur/:id" element={<ProducteurSingle />} />
          <Route path="/login" element={<Login />} />
          <Route path="/signIn" element={<SignIn />} />
          {/*<Route path="/commandes" element={
                <NeedAuth logged={logged} children={<Commande />}></NeedAuth>
          }/>*/}
          <Route path="/calendrier" element={
                <NeedAuth logged={logged} children={<Calendrier />}></NeedAuth>
          }/>

          <Route path="/account/*" element={
                <NeedAuth logged={logged} children={<Account />}></NeedAuth>
          }/>

          <Route path="/account/*">
           <Route index element={<NeedAuth logged={logged} children={<Account />}></NeedAuth>} />
           <Route path="commandes" element={<Parametres />} />
           <Route path="paiement" element={<Parametres />} />
           <Route path="parametres" element={<Parametres />} />
         </Route>
        </Routes>
      </BrowserRouter>
    </>
  )
}
