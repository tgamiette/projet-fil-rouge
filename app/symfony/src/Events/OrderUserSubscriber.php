<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\OrderSeller;
use App\Entity\OrderUser;
use App\Entity\ProductsOrder;
use App\Repository\OrderSellerRepository;
use App\Repository\OrderUserRepository;
use App\Repository\ProductsOrderRepository;
use App\Repository\ProductsRepository;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;


class OrderUserSubscriber implements EventSubscriberInterface {

    private Security $security;
    private OrderUserRepository $orderUserRepository;
    private OrderSellerRepository $orderSellerRepository;
    private ProductsOrderRepository $productsOrderRepository;
    private ProductsRepository $productsRepository;

    public function __construct(Security $security, OrderUserRepository $orderUserRepository, OrderSellerRepository $orderSellerRepository, ProductsRepository $productsRepository, ProductsOrderRepository $productsOrderRepository) {

        $this->security = $security;
        $this->productsRepository = $productsRepository;
        $this->productsOrderRepository = $productsOrderRepository;
        $this->orderUserRepository = $orderUserRepository;
        $this->orderSellerRepository = $orderSellerRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents() {
        return [
            KernelEvents::VIEW => [
                ['setOrder', EventPriorities::POST_WRITE],
            ]
        ];
    }

//TODO affecer automatique au bon order seller rajouter le customer automatiquement dans la requete api
// ajouter la date autolatiquement
    public function setOrder(ViewEvent $event) {
        $order = $event->getControllerResult();
        if ($event->getRequest()->isMethod("POST") && $order instanceof OrderUser) {
            dd($order);

        }
//            $order->setCustomer($this->security->getUser());
//            foreach ($order->getProducts() as $data) {
//                self::checkOrderData($data);
//
//                if (!$this->productsRepository->find($id)) {
//                    $event->setResponse(new Response("produit $id introuvable", 500));
//                    $event->stopPropagation();
//                }
//            }
//        }
    }

    /**
     * Check du fichier JSON passé dans l'API
     * @param array $data
     * @return void
     */
    public function checkOrderData(array $data): void {
        $product = $this->productsRepository->find($data['product']);
        unset($data['product']);
        $productOrder = new ProductsOrder($data);
        $productOrder->setUpdatedAt(new \DateTime());
        $productOrder->setProduct($product);
        $productOrder->setPrixU($product->getPrice());
        $productOrder->setTotal($product->getPrice() * $productOrder->getQuantity());
        $productOrder->setUnit($product->getUnit());

        if (!$this->productsRepository->find($id)) {
            $event->setResponse(new Response("produit $id introuvable", 500));
            $event->stopPropagation();
        }
    }
}
