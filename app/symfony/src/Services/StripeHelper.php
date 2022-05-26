<?php

namespace App\Services;

use App\Entity\OrderUser;
use App\Repository\PurchaseRepository;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use function Sodium\add;

class StripeHelper {

    private mixed $privateKey;
    private PurchaseRepository $purchaseRepository;

    public function __construct() {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

    /**
     * @throws ApiErrorException
     */
    public static function PaymentIntent(OrderUser $order): ?string {
        $intent = PaymentIntent::create([
            'amount' => (int)$order->getTotal(),
            'currency' => 'eur',
        ]);


        return $intent->client_secret;
    }
}
