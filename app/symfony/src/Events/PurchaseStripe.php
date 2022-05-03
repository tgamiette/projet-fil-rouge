<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\OrderSeller;
use App\Entity\OrderUser;
use App\Repository\OrderSellerRepository;
use App\Repository\OrderUserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class OrderUserSubscriber implements EventSubscriberInterface {

    private Security $security;
    private OrderUserRepository $orderUserRepository;
    private OrderSellerRepository $orderSellerRepository;

    public function __construct(Security $security, OrderUserRepository $orderUserRepository, OrderSellerRepository $orderSellerRepository) {

        $this->security = $security;
        $this->orderUserRepository = $orderUserRepository;
        $this->orderSellerRepository = $orderSellerRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents() {
//        return[KernelEvents::VIEW=>['setOrder',EventPriorities::PRE_VALIDATE]];
        return [KernelEvents::VIEW => ['setOrder2', EventPriorities::PRE_VALIDATE]];
    }


//TODO affecer automatique au bon order seller rajouter le customer automatiquement dans la requete api
// ajouter la date autolatiquement
    public function setOrder(ViewEvent $event) {
        $order = $event->getControllerResult();
        if ($event->getRequest()->isMethod("POST") && $order instanceof OrderUser) {
            var_dump($order->getProduct());
            die();
            //TODO blablbalba
//            $order->
//            $order->setTotal()
//            $product->setSeller($this->security->getUser());
        }
        elseif ($event->getRequest()->isMethod("POST") && $order instanceof OrderSeller) {
            //TODO blablabla
        }
    }

    public function setOrder2(ViewEvent $event) {
        $orderUser=  $event->getControllerResult();

        if($orderUser instanceof  OrderUser){
            $products =$orderUser->getProduct();
            foreach ($products as $product){
            }
        }
    }

}
