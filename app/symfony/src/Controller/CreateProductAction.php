<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class CreateProductAction extends AbstractController {

    public function __invoke(Request $request) {

        $data = $request->attributes->get('data');

        if ($data instanceof Product) {

            if (is_numeric($data->getPrice())) {
                $data->setPrice((int)$data->getPrice());
            }
            if (is_numeric($data->getQuantity())) {
                $data->setQuantity((int)$data->getQuantity());
            }
        }
        return $data;
    }
}
