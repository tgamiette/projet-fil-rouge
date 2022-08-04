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
             <Link to="/account/produits/ajout">Ajoutés un produits</Link>
             <Link to="/account/produits">Mes produits</Link>
            </>
            :
            null
        }
        <Link to="/account/commandes">Mes Commandes</Link>

     </ul>
   </nav>
  </div>
 )
}
