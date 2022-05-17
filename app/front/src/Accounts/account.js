import React from 'react';
import SubNav from './nav'
import './style/account.css';

export default function Account(){

 return (
  <div className="c-account">
    <SubNav />
     <div className="c-nav account">
        <div className="c-user_infos">
           <span className="c-user_img"></span>
           <p>User Name <br/>
           <span className="is__light">User Town</span></p>

        </div>

        <form className="c-user_form">
            <div className="c-form_wrapper">
              <label className="">Nom</label>
              <input type="text" name="nom"  />
            </div>
            <div className="c-form_wrapper">
              <label className="">Prénom</label>
              <input className="" type="text" name="prenom"  />
            </div>

            <div className="c-form_wrapper">
              <label className="">Email</label>
              <input className="" type="email" name="email"  />
            </div>

            <div className="c-form_wrapper">
              <label className="">Téléphone</label>
              <input className="" type="phone" name="phone"  />
            </div>

            <div className="c-form_wrapper">
              <label className="">Adresse</label>
              <input className="" type="text" name="adresse"  />
            </div>

            <div className="c-form_wrapper">
              <label className="">Code Postal</label>
              <input className="" type="number" name="postal"  />
            </div>

           <button className="c-btn is__form" type="submit">Sauvegarder</button>
         </form>
     </div>
  </div>
 )
}
