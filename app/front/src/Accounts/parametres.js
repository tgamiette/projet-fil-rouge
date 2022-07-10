import React, {useState} from 'react';
import SubNav from './nav'

import Qrcode from '../Components/Qrcode/qrcode';


export default function Parametres({}){

  return(
    <div className="c-account">
      <SubNav />
      <div className="c-parameters">
        <h1>Paramètres</h1>
        <Qrcode />
      </div>

    </div>
  )
}
