<?php

namespace App\Controller\WebHook;

use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController {

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em=$em;
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

                return $this->json($paymentIntent, 200);
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        return $this->json($paymentIntent, 200);

    }

    public function success($id, PurchaseRepository $purchaseRepository) {
        $purchase = $purchaseRepository->find($id);

        if (
            !$purchase ||
            ($purchase->getOrderUser()->getCustomer() !== $this->getUser()) ||
            $purchase->getStatus() === Purchase::STATUS_PAID)
        {
            return $this->json("L'utilisateur connecter n'est pas l'utisateur ayant payer la commande", 500);
         }

        $purchase->setStatus(Purchase::STATUS_PAID);
        $this->em->flush();
    }


}
