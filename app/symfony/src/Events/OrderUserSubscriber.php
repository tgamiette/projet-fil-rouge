<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\OrderSeller;
use App\Entity\OrderUser;
use App\Repository\OrderSellerRepository;
use App\Repository\OrderUserRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;


class OrderUserSubscriber implements EventSubscriberInterface {

    private Security $security;
    private OrderUserRepository $orderUserRepository;
    private OrderSellerRepository $orderSellerRepository;

    public function __construct(Security $security, OrderUserRepository $orderUserRepository, OrderSellerRepository $orderSellerRepository, ProductsRepository $productsRepository) {

        $this->security = $security;
        $this->productsRepository = $productsRepository;
        $this->orderUserRepository = $orderUserRepository;
        $this->orderSellerRepository = $orderSellerRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents() {
        return [KernelEvents::VIEW => ['setOrder', EventPriorities::POST_VALIDATE]];
    }

//TODO affecer automatique au bon order seller rajouter le customer automatiquement dans la requete api
// ajouter la date autolatiquement
    public function setOrder(ViewEvent $event) {
        $order = $event->getControllerResult();
        if ($event->getRequest()->isMethod("POST") && $order instanceof OrderUser) {
            $order->setCustomer($this->security->getUser());
            foreach ($order->getProducts() as $productOrder) {
                $uri= $productOrder['product'];
                (int) $id =  explode('/', $uri)[3];
                if(!$this->productsRepository->find($id)){
                    $event->setResponse(new Response("$uri introuvable", 500));
                }
            }
        }

    }

}
