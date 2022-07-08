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


        {
          user.role === 'ROLE_ADMIN' || user.role === 'ROLE_SELLER'?
            <>
             <Link to="produits/ajout">Ajoutés un produits</Link>
             <Link to="produits">Mes produits</Link>
            </>
            :
            <Link to="commandes">Mes Commandes</Link>
        }
        <Link to="parametres">Parametres</Link>

     </ul>
   </nav>
  </div>
 )
}
