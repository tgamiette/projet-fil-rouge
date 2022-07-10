<?php

namespace App\Controller\api;

use App\Entity\OrderUser;
use App\Repository\ProductsOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

#[AsController]
final class CheckOrderUser extends AbstractController {

    public function __construct(private DenormalizerInterface $denormalizer, private ProductsOrderRepository $productsOrderRepository, private Security $security) {
    }

    public function __invoke(Request $request) {
        $data = $request->attributes->get('data');

        if ($data instanceof OrderUser) {
            $productsOrder = $this->productsOrderRepository->findProductsPickUp($this->security->getUser(), $data);
//            return $productsOrder;

        }
        return $data;

    }
}
