import { Link } from "react-router-dom";

export default function SubNav({}){
 return(
  <div className="c-nav account">
  <p>hello</p>
   <nav>
     <ul>
        <Link to="/account">Mes Informations</Link>
        <Link to="commandes">Mes Commandes</Link>
        <Link to="paiements">Mes Paiements</Link>
        <Link to="parametres">Parametres</Link>
     </ul>
   </nav>
  </div>
 )
}
