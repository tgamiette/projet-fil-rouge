import React, {useState} from 'react';
import { CardElement, useElements, useStripe} from "@stripe/react-stripe-js";



export default function PayementForm({}){

  const [success, setSuccess] = useState(false);
  const stripe = useStripe();
  const elements = useElements();

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!stripe || !elements) {
      // Stripe.js has not yet loaded.
      // Make sure to disable form submission until Stripe.js has loaded.
      return;
    }

    const {error, payementMethod} = await stripe.createPayementMethod({
      type: "card",
      card: elements.getElement(CardElement),
    });

    if(!error){
      try {
        const {id} = payementMethod
        const response = await fetch("http://localhost:8000/api/stripe", {
          amount: 1000,
          id
        })

        if(response.data.success){
          console.log('success');
          setSuccess(true);
        }
      } catch (e) {
          console.log('error', e);
      }
    }else {
      console.log('error', error.message);
    }
  }

  return(
    <>
      {
        !success ?
          <form onSubmit={handleSubmit}>
            <CardElement />
            <button type="submit" disabled={!stripe || !elements}>Payer</button>
          </form>

      :
      <div>
        <h2>Vous avez déjà acheter</h2>
      </div>
      }
    </>
  )
}
