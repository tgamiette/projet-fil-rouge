import React, {useState, useEffect} from 'react';
import {add_user} from '../api';
import { useWaitFor } from "../shared/hooks";
import { useLocation } from 'react-router-dom';
import {useNavigate} from "react-router-dom"

export default function SignIn(){

  const [user, setUser] = useState({fullName: "", password: "", email: "", roles: ""});
  const navigate = useNavigate();

  useWaitFor(
     () => add_user(user.email, user.password, user.fullName, user.roles),
     [user],
     (res) => {
      if(res.id){
       navigate("/login");
     }else{
       return null
     }
      console.log(res);
     }
   );

  const handleSubmit = (e) => {
    e.preventDefault();
    setUser({
      email: e.target.email.value,
      password: e.target.password.value,
      fullName: `${e.target.prenom.value} ${e.target.nom.value}`,
      roles: e.target.roles.value
    });
  }

 return(
   <div className="c-bg is__full">
     <div className="c-form">
     <h1>SignIn</h1>

     <div className="error-message">
      <p></p>
     </div>

     <form className="" onSubmit={handleSubmit}>

      <div className="c-form_wrapper">
       <label className="">Nom</label>
       <input type="text" name="nom"  />
      </div>

      <div className="c-form_wrapper">
        <label className="">Prénom</label>
        <input type="text" name="prenom"  />
      </div>

      <div className="c-form_wrapper">
      <label>Vous êtes ?</label>
        <label className="acheteur">Acheteur</label>
        <input type="radio" id="acheteur" name="roles"  value="ROLE_USER"/>
        <label className="vendeur">Producteur</label>
        <input type="radio" id="vendeur" name="roles"  value="ROLE_SELLER"/>
      </div>

      <div className="c-form_wrapper">
        <label className="">Email</label>
        <input type="email" name="email"  />
      </div>

      <div className="c-form_wrapper">
        <label className="">Password</label>
        <input className="" type="password" name="password"  />
      </div>

      <button className="c-btn " type="submit">S'inscrire</button>
     </form>

    </div>

   </div>
 )
}
