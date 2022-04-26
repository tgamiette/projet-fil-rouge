<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Product;
use App\Repository\ProductsRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class ProductSubscriber implements EventSubscriberInterface {

    private Security $security;
    private ProductsRepository $productsRepository;

    public function __construct(Security $security ,ProductsRepository $productsRepository) {

        $this->security= $security;
        $this->productsRepository= $productsRepository;
    }

    /**
	 * @inheritDoc
	 */
	public static function getSubscribedEvents() {
        return[KernelEvents::VIEW=>['setProduct',EventPriorities::PRE_VALIDATE]];
	}



    public function setProduct(ViewEvent $event) {
        $product = $event->getControllerResult();
        if($event->getRequest()->isMethod("POST") && $product instanceof Product){
            $product->setSeller($this->security->getUser());
        }
    }
}
