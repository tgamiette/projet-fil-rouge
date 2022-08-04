import React, {useState} from 'react';
import SubNav from './nav'
import './style/account.css';
import {useSelector} from 'react-redux';
import {selectUser} from '../redux/userSlice';
import {get_user_infos, get_user} from '../api';
import {useWaitFor} from '../shared/hooks';

export default function Account(){


  const [account, setAccount] = useState(false);
  const [infos, setInfos] = useState(false);
  const user = useSelector(selectUser);

  console.log(user);
  useWaitFor(
    () => get_user(user.id),[],(res) => {
      console.log('infos', res);
      setInfos(res);

      console.log(res.fullName.split(" ")[0]);
    }
  );



 return (
  <div className="c-account">
    <SubNav />
     <div className="c-nav account">
       {
         infos !== undefined && infos !== false?
         <>
         <div className="c-user_infos">
            <span className="c-user_img">
              <img src={require(`../assets/images/user_${user.id.toString().slice(-1)}.png`)} alt="" />
            </span>
            <p>{infos.fullName}<br/>
            <span className="is__light">{account !== undefined && account !== false? account.adress : "non renseigné" }</span></p>
         </div>

         <form className="c-user_form">
             <div className="c-form_wrapper">
               <label className="">Nom</label>
               <input type="text" name="nom"  value={infos.fullName.split(" ")[0]}/>
             </div>
             <div className="c-form_wrapper">
               <label className="">Prénom</label>
               <input className="" type="text" name="prenom" value={infos.fullName.split(" ")[1]} />
             </div>

             <div className="c-form_wrapper">
               <label className="">Email</label>
               <input className="" type="email" name="email" value={user.email} />
             </div>

             <div className="c-form_wrapper">
               <label className="">Adresse</label>
               <input className="" type="text" name="adresse"  value={account !== undefined && account !== false ? account.adress : "non renseigné"}/>
             </div>

             <div className="c-form_wrapper">
               <label className="">Code Postal</label>
               <input className="" type="number" name="postal"  value="non renseigné" />
             </div>
          </form>
         </>
         :
         null
       }


     </div>
  </div>
 )
}
