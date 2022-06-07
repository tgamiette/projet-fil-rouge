<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Repository\OrderSellerRepository;
use App\Repository\OrderUserRepository;
use App\Repository\ProductsOrderRepository;
use App\Repository\ProductsRepository;

use App\Repository\PurchaseRepository;
use App\Services\StripeHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;


class MediaObjectSubscriber implements EventSubscriberInterface {

    private Security $security;
    private OrderUserRepository $orderUserRepository;
    private OrderSellerRepository $orderSellerRepository;
    private ProductsOrderRepository $productsOrderRepository;
    private ProductsRepository $productsRepository;

    public function __construct(Security $security, OrderUserRepository $orderUserRepository, OrderSellerRepository $orderSellerRepository, ProductsRepository $productsRepository, ProductsOrderRepository $productsOrderRepository, PurchaseRepository $purchaseRepository) {

        $this->security = $security;
        $this->productsRepository = $productsRepository;
        $this->productsOrderRepository = $productsOrderRepository;
        $this->orderUserRepository = $orderUserRepository;
        $this->orderSellerRepository = $orderSellerRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents() {
        return [
            KernelEvents::VIEW => [
                ['prevalidate', EventPriorities::PRE_VALIDATE],
                ['postValidate', EventPriorities::POST_VALIDATE],
            ]
        ];
    }

    public function prevalidate(ViewEvent $event) {
//        dd($event->getControllerResult());
        if ($event->getRequest()->isMethod("POST") ) {
        }
    }

    public function postValidate(ViewEvent $event) {
//        dd('post');

        if ($event->getRequest()->isMethod("POST")) {
            echo "";
        }
    }
}
