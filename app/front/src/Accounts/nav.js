import React from 'react';
import { Link } from "react-router-dom";

export default function SubNav({}){
 return(
  <div className="c-nav account">
   <nav>
     <ul>
        <Link to="/account">Mes Informations</Link>
        <Link to="commandes">Mes Commandes</Link>
        <Link to="paiements">Mes Paiements</Link>
        <Link to="parametres">Parametres</Link>

        <Link to="produits">Mes produits</Link>
        <Link to="produits/ajout">Ajoutés un produits</Link>

     </ul>
   </nav>
  </div>
 )
}
