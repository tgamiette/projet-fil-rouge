import React, {useState} from 'react';
import SubNav from './nav'
import {get_all_orders_users} from '../api';
import {useWaitFor} from '../shared/hooks';
import './style/account.css';
import {useSelector} from 'react-redux';
import {selectUser} from '../redux/userSlice';
import Qrcode from '../Components/Qrcode/qrcode';
import PopupQrCode from '../Components/Qrcode/popupQrcode'

export default function Commandes({}){

  const [orders, setOrders] = useState(false);
  const user = useSelector(selectUser);
  const [active, setActive] = useState(false);
  const [infos, setInfos] = useState(false);

  useWaitFor(
    () => get_all_orders_users(),[],(res) => {
      console.log('res', res['hydra:member']);
      setOrders(res['hydra:member']);
    }
  );

  const handleQrcode = ({commande, text}) => {
    setActive(true);
    setInfos({nbCommande: commande, text: text});
  }


  return(
    <div className="c-account">
      <SubNav />
      <div>
        <h1>Mes commandes</h1>
        <table className="c-orders">
          <thead>
            <td>ID</td>
            <td>Numéro de la commande </td>
            <td>Coût</td>
            <td>Nombre de produits</td>
            <td>QR Code</td>
          </thead>
          <tbody>
            {
              orders !== false && orders !== undefined ?
                <>
                {
                  orders.map((item, index) => {
                    return(
                      <>
                      {
                        item.buyer['@id'].split("/").pop() == user.id ?
                          <tr key={index}>
                             <td>{index + 1}</td>
                             <td>n°{item['@id'].split("/").pop()}</td>
                             <td>{item.total}€</td>
                             <td>{item.productsOrders.length} produits</td>
                             <td>
                               <Qrcode text={item['@id'].split("/").pop()} size={50}/>
                               <button type="button" className="c-btn" onClick={() => handleQrcode({commande: item['@id'].split("/").pop(), text: item['@id'].split("/").pop()})}>Voir le Qr Code</button>
                             </td>
                           </tr>
                        :
                        null
                      }
                      </>
                    )
                  })
                }
                </>
              :
              <p>Vous n'avez encore passé aucune commande !</p>
            }
          </tbody>
        </table>


      </div>

      {infos !== false ? <PopupQrCode active={active} setActive={setActive} nbCommande={infos.nbCommande} text={infos.text} /> : null}




    </div>
  )
}
