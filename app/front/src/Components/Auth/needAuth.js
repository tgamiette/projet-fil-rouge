import React from 'react';
import { useLocation } from 'react-router-dom';
import {Navigate} from 'react-router-dom';
import {useSelector} from 'react-redux';
import {selectUser} from "../../redux/userSlice";

export default function NeedAuth({children}){
  let location = useLocation();
  const user = useSelector(selectUser);

  if(user){
    return children;
  }else{
    return <Navigate to="/login" state={{from: location}} />
  }
}
