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
   <div className="c-bg is__full">
      <div className="c-form">
       <h1>Login</h1>
       <form onSubmit={handleLogin}>
         <div className="c-form_wrapper">
           <label className="">Email</label>
           <input type="email" name="email"  />
         </div>
         <div className="c-form_wrapper">
           <label className="">Password</label>
           <input className="" type="password" name="password"  />
         </div>

        <button className="c-btn is__form" type="submit">Se connecter</button>
       </form>

       <p>Vous n'avez pas encore de compte ? <Link to="/signIn">S'inscrire</Link></p>
      </div>
   </div>
 )
}
