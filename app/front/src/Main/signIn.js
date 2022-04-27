import React, {useState, useEffect} from 'react';
import {add_user} from '../api';
import { useWaitFor } from "../shared/hooks";

export default function SignIn(){

  const [user, setUser] = useState({username: "", password: "", email: ""});

  useWaitFor(
     () => add_user(user.email, user.password, user.username),
     [user],
     (res) => {
       console.log('user', res);
     }
   );

  const handleSubmit = (e) => {
    e.preventDefault();
    setUser({
      email: e.target.email.value,
      password: e.target.password.value,
      username: `${e.target.prenom.value} ${e.target.nom.value}`
    });
  }

 return(
  <>
   <h1>SignIn</h1>

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
