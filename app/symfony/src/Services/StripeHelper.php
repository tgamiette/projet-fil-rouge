<?php

namespace App\Services;

use App\Entity\OrderUser;
use App\Repository\PurchaseRepository;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use function Sodium\add;

class StripeHelper {

    private  $secretKey;
    private PurchaseRepository $purchaseRepository;

    public function __construct() {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

//    public function __construct($secretKey , $publicKey) {
//        $this->privateKey = $secretKey;
//        $this->publicKey = $publicKey;
//    }

    /**
     * @throws ApiErrorException
     */
    public static function CreatePaymentIntent(OrderUser $order): ?string {

        $intent = PaymentIntent::create([
            'amount' => (int)$order->getTotal(),
            'currency' => 'eur',
            'description' => "Paiement de la commande " . $order->getId(),
            "metadata" => ["order" => $order->getId()]
        ]);


        return $intent->client_secret;
    }
}
