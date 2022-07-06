<?php

namespace App\Controller\api;

use ApiPlatform\Core\Exception\ItemNotFoundException;
use App\Entity\OrderUser;
use App\Entity\ProductsOrder;
use App\Repository\ProductsOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

#[AsController]
final class PickUpProduct extends AbstractController {

    public function __construct(private ProductsOrderRepository $productsOrderRepository, private Security $security) {
    }

    public function __invoke(Request $request) {
        $data = $request->attributes->get('data');
        $array = array();

        if ($data instanceof OrderUser) {
            $body = json_decode($request->getContent());
            $body->product ?? throw new ItemNotFoundException("Field product missing", 400);

            foreach ($body->product as $productOrderId) {
                $productOrder = $this->productsOrderRepository->find($productOrderId);

                if ($productOrder && $productOrder->getOrder() === $data) {

                    if (!$this->security->isGranted('ORDER_USER_PICKUP', $productOrder)) {
                        throw new AccessDeniedException("Access to product order $productOrderId refused or doesn't exist");
                    }
                    $productOrder->setStatus(ProductsOrder::STATUT_DELIVER);
                }
                else {
                    throw new ItemNotFoundException("Access to product order $productOrderId refused or doesn't exist", 403);
                }
            }
        }

        return $data;
    }
}
