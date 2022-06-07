import React from 'react';
import {Elements} from "@stripe/react-stripe-js";
import {loadStripe} from "@stripe/stripe-js";
import PayementForm from "./payementForm"

export default function Stripe({}){

  const PUBLIC_KEY = "pk_test_51L3dOwBiGNmxgtVH2rbYSjTsZGSM2koXnpZE27V4CgJSwTI1SlFGDwcu8Nm9zfNbpgOwVmSbZlOKqASI3PebA6zO00jHvxDq7d";
  const PRIVATE_KEY = "sk_test_51L3dOwBiGNmxgtVHZu8QF4WzeV5hI3v2Ql4PnW0OocNcF9F35VlTi77DffYbZIYSbbKK8lrQaYU7uRXKFyQwNIeK00VWr2MCBo";


  const stripe = loadStripe("pk_test_oKhSR5nslBRnBZpjO6KuzZeX");

  return(
    <div>
      <Elements stripe={stripe}>
        <PayementForm />
      </Elements>
    </div>
  )

}
