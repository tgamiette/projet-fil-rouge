import React from "react";
import Qrcode from './qrcode';

export default function PopupQrCode({nbCommande, text, active, setActive}){
  console.log(nbCommande, text);
  return(
    <div className={`c-popup_bg ${active ? "active" : ""}`}>
      <div className="c-popup_buy">
        <h2>Qr Code commande n°{nbCommande}</h2>
        <Qrcode text={text} size={400}/>
        <button type="button" className="c-btn" onClick={() => setActive(false)}>Fermer</button>
      </div>
    </div>
  )
}
