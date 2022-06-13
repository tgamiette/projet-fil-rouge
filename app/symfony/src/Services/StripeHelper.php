<?php

namespace App\Services;

use App\Entity\OrderUser;
use App\Repository\PurchaseRepository;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use function Sodium\add;

class StripeHelper {

    private PurchaseRepository $purchaseRepository;

    public function __construct() {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

    /**
     * @throws ApiErrorException
     */
    public static function CreatePaymentIntent(OrderUser $order): PaymentIntent {
        $intent = PaymentIntent::create([
            'amount' => (int)$order->getTotal(),
            'currency' => 'eur',
            'description' => "Paiement de la commande " . $order->getId() . " de " ,
            "metadata" => [
                "orderId" => $order->getId(),
//                "userId" => $order->getBuyer(),
            ]
        ]);

        return $intent;
    }

    public static function GetPaymentIntent($clientSecret): ?string {

        $intent = PaymentIntent::retrieve($clientSecret);

        return $intent;
    }
}
