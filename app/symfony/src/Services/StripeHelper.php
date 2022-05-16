<?php

namespace App\Services;

use App\Entity\Purchase;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Symfony\Bundle\MakerBundle\Str;

class StripeHelper {

    private mixed $privateKey;

    public function __construct() {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

    public function PaymentIntent(Purchase $purchase) {
        $intent = PaymentIntent::create([
            'amount' => $purchase->getTotal,
            'currency' => 'eur'
        ]);
        return $intent->client_secret;
    }
}
