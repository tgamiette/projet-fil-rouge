import React, {useState} from 'react';
import QRCode from "react-qr-code";

export default function Qrcode({text, size}){
  return(
    <div style={{ background: 'white', padding: '16px' }}>
      <QRCode value={text.toString()} size={size}/>
    </div>
  )
}
