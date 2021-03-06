import React, { useState, useEffect } from "react";
import { loadStripe } from "@stripe/stripe-js";
import { Elements } from "@stripe/react-stripe-js";
import {set_order_user} from '../api';
import {useWaitFor} from '../shared/hooks';
import CheckoutForm from "./checkoutForm";


const stripePromise = loadStripe("pk_test_51KiN93JH5pyW7JphbDnCJ9t9UrmLbixCBgRJgNt6RjNQISXqVkoiNypvT1ZHidfemx2yZUJfWTYlVNBoR4Sk1wqY00jNwByviV");


export default function Stripes({}){

  const [clientSecret, setClientSecret] = useState("");

  useWaitFor(
    () => set_order_user(),[],(res) => {
      console.log('order', res);
      setClientSecret(res.token);
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
          <CheckoutForm/>
        </Elements>
      )}
    </div>
  );
}
