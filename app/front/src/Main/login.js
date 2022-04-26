import React from 'react';
import { Link } from "react-router-dom";

export default function Login(){

 return(
   <>
    <h1>Login</h1>
    <p>Vous n'avez pas encore de compte ? <Link to="/signIn">S'inscrire</Link></p>
   </>
 )
}
