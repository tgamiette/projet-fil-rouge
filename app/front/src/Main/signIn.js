import React, {useState, useEffect} from 'react';
import {add_user} from '../api';
import { useWaitFor } from "../shared/hooks";
import { useLocation } from 'react-router-dom';
import {useNavigate} from "react-router-dom"

export default function SignIn(){

  const [user, setUser] = useState({fullName: "", password: "", email: ""});
  const navigate = useNavigate();

  useWaitFor(
     () => add_user(user.email, user.password, user.fullName),
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
      fullName: `${e.target.prenom.value} ${e.target.nom.value}`
    });
  }

 return(
  <>
   <h1>SignIn</h1>

   <div className="error-message">
    <p>
   </div>

   <form className="" onSubmit={handleSubmit}>
    <label className="">Nom</label>
    <input type="text" name="nom"  />

    <label className="">Prénom</label>
    <input type="text" name="prenom"  />

    <label className="">Email</label>
    <input type="email" name="email"  />

    <label className="">Password</label>
    <input className="" type="password" name="password"  />

    <button className="" type="submit">S'inscrire</button>
   </form>
  </>
 )
}
