<?php

namespace App\Controller\WebHook;

use App\Entity\Product;
use App\Entity\ProductsOrder;
use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
use App\Services\OrderHelper;
use App\Services\ProductsOrderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController {

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, private ProductsOrderHelper $productsOrderHelper, private PurchaseRepository $purchaseRepository) {
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
                try {
                    $paymentIntent = $event->data->object;
                    $purchase = $this->purchaseRepository->findOneBy(['stripeToken' => $paymentIntent->client_secret]);
                    if (!$purchase) {
                        throw new \Exception("Purchase non trouvé", 500);
                    }
                    //$metadata = $paymentIntent->metadata;
                    self::successPayment($purchase);

                }
                catch (\Exception $exception) {
                    return $this->json($exception, 500);
                }

                $this->json($paymentIntent, 400);
            default:
                echo 'reception evenement inconnu' . $event->type;
        }
        return $this->json($paymentIntent, 200);
    }

    /*
     * Valide la commande
     */
    private function successPayment(Purchase $purchase) {

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
