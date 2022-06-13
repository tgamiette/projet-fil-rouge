import React, { useState, useEffect } from "react";
import { loadStripe } from "@stripe/stripe-js";
import { Elements } from "@stripe/react-stripe-js";
import {set_order_user} from '../api';
import {useWaitFor} from '../shared/hooks';
import CheckoutForm from "./checkoutForm";


const stripePromise = loadStripe("pk_test_51L3dOwBiGNmxgtVH2rbYSjTsZGSM2koXnpZE27V4CgJSwTI1SlFGDwcu8Nm9zfNbpgOwVmSbZlOKqASI3PebA6zO00jHvxDq7d");


export default function Stripes({}){

  const [clientSecret, setClientSecret] = useState("");

  useWaitFor(
    () => set_order_user(),[id],(res) => {
      console.log('order', res);
      setClientSecret(res.clientSecret);
    }
  );

  const appearance = {
    theme: 'stripe',
  };
  const options = {
    clientSecret,
    appearance,
  };


  return (
    <div className="App">
      {clientSecret && (
        <Elements options={options} stripe={stripePromise}>
          <CheckoutForm />
        </Elements>
      )}
    </div>
  );
}
