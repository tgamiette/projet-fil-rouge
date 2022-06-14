import React from 'react';
import { Link } from "react-router-dom";
import {useSelector} from 'react-redux';
import {selectUser} from '../redux/userSlice';


export default function SubNav({}){

  const user = useSelector(selectUser);

 return(
  <div className="c-nav account c-card">
   <nav>
     <ul>
        <Link to="/account">Mes Informations</Link>
        <Link to="commandes">Mes Commandes</Link>
        <Link to="produits">Mes produits</Link>
        {
          user.role === 'ROLE_ADMIN'?
            <Link to="produits/ajout">Ajoutés un produits</Link>
            :
            null
        }
        <Link to="parametres">Parametres</Link>

     </ul>
   </nav>
  </div>
 )
}
