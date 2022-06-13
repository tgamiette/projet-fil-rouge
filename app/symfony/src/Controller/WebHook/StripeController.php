<?php

namespace App\Controller\WebHook;

use App\Entity\ProductsOrder;
use App\Entity\Purchase;
use App\Services\OrderHelper;
use App\Services\ProductsOrderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController {

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, private ProductsOrderHelper $productsOrderHelper) {
        $this->em = $em;
    }

    #[Route('/stripe', name: 'paymentIntent')]
    public function stripe(): Response {
// This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = 'whsec_6bf5148134380a478fd975af9983984576d25d4527bcfb5fb8f176f4e3d2c1d4';
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        }
        catch (\UnexpectedValueException $e) {
            // Invalid payload
            return $this->json($e, 400);
        }
        catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return $this->json($e, 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $data = $paymentIntent->charges->data[0];
                $order = $data->order;

                return $this->json($data, 200); die();

                self::success($purchase);
                $this->json('coucou', 400);
                $this->json($paymentIntent, 400);
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        return $this->json($paymentIntent, 200);
    }

    /*
     * check la commande duu paiment et verifier si
     */
    private function success(Purchase $purchase) {
        $purchase->setStatus(Purchase::STATUS_PAID);

        $OrderUser = $purchase->getOrderUser();
        $productsOrder = $OrderUser->getProductsOrders();

        foreach ($productsOrder as $productOrder) {
            $productOrder->setStatus(ProductsOrder::STATUT_PAID);
            $this->productsOrderHelper->checkObjective($productOrder);
        }

        $this->em->flush();
    }


}
