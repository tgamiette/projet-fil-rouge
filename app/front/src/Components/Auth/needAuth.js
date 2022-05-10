import { useLocation } from 'react-router-dom';
import {Navigate} from 'react-router-dom';

export default function NeedAuth({logged, children}){
  let location = useLocation();

  if(logged){
    return children;
  }else{
    return <Navigate to="/login" state={{from: location}} />
  }
}
