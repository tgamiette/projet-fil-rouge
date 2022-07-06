<?php

namespace App\Controller\api;

use App\Entity\MediaObject;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
//le but est de retourner l'object

final class CreateMediaObjectAction extends AbstractController {

    public function __construct(private ProductsRepository $productsRepository) {
    }

    public function __invoke(Request $request): MediaObject {
        $uploadedFile = $request->files->get('file');
        $productId = (int)$request->request->get('product');
        $product = $this->productsRepository->find($productId);
//        if (!$uploadedFile) {
//            throw new BadRequestHttpException('"file" is required');
//        }
//        if (!$product) {
//            throw new BadRequestHttpException('" product" is not found check id');
//        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $uploadedFile;
        $mediaObject->product = $product;

        return $mediaObject;
    }
}
