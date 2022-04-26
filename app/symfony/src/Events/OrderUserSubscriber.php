<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\OrderSeller;
use App\Entity\OrderUser;
use App\Entity\Product;
use App\Repository\OrderSellerRepository;
use App\Repository\OrderUserRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class OrderUserSubscriber implements EventSubscriberInterface {

    private Security $security;
    private OrderUserRepository $orderUserRepository;
    private OrderSellerRepository $orderSellerRepository;

    public function __construct(Security $security ,OrderUserRepository $orderUserRepository, OrderSellerRepository $orderSellerRepository) {

        $this->security= $security;
        $this->orderUserRepository= $orderUserRepository;
        $this->orderSellerRepository= $orderSellerRepository;
    }

    /**
	 * @inheritDoc
	 */
	public static function getSubscribedEvents() {
        return[KernelEvents::VIEW=>['setOrder',EventPriorities::PRE_VALIDATE]];
	}


//TODO affecer automatique au bon order seller rajouter le customer automatiquement dans la requete api
// ajouter la date autolatiquement
    public function setOrder(ViewEvent $event) {
        $order = $event->getControllerResult();
        if($event->getRequest()->isMethod("POST") && $order instanceof OrderUser){
            //TODO blablbalba
//            $order->
//            $order->setTotal()
//            $product->setSeller($this->security->getUser());
        }elseif ($event->getRequest()->isMethod("POST") && $order instanceof OrderSeller){
            //TODO blablabla
        }
    }
}
