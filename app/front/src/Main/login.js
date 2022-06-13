import React, {useState, useEffect} from 'react';
import { Link, useNavigate } from "react-router-dom";
import {logIn,setToken} from '../api';
import {useDispatch} from "react-redux";
import {login} from "../redux/userSlice";

export default function Login(){

   const [user, setUser] = useState(false);
   const dispatch = useDispatch();
   const navigate = useNavigate();

   useEffect(() => {
      console.log('user', user);
      if(user !== false){
         logIn(user.email, user.password)
         .then(data => {
           console.log(data);
           if(data.code !== 401){
               console.log(data);
               dispatch(login({
                 email: user.email,
                 token: data.token
               }));
               setToken(data.token);
               navigate('/');
           }
         });
      }
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
