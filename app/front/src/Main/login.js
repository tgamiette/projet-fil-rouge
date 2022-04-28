import React, {useState, useEffect} from 'react';
import { Link } from "react-router-dom";
import {logIn} from '../api';

export default function Login(){

   const [user, setUser] = useState(false);

   useEffect(() => {
      console.log('user', user);
      logIn(user.email, user.password);
   }, [user]);

   const handleLogin = (e) => {
     e.preventDefault();
      setUser({email: e.target.email.value, password: e.target.password.value});
   }


 return(
   <>
    <h1>Login</h1>

    <form className="" onSubmit={handleLogin}>
     <label className="">Email</label>
     <input type="email" name="email"  />

     <label className="">Password</label>
     <input className="" type="password" name="password"  />

     <button className="" type="submit">Se connecter</button>
    </form>

    <p>Vous n'avez pas encore de compte ? <Link to="/signIn">S'inscrire</Link></p>
   </>
 )
}
