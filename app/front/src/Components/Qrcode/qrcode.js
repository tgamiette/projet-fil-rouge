import React, {useState} from 'react';
import QRCode from "react-qr-code";

export default function Qrcode({}){

  const [text, setText] = useState("https://google.fr");

  const handleText = (e) =>{
    setText(e.target.value);
  }

  return(
    <div style={{ background: 'white', padding: '16px' }}>
      <input type="text" name="test" value={text} onChange={(e) => handleText(e)}/>
      <QRCode value={text}/>
    </div>
  )
}
