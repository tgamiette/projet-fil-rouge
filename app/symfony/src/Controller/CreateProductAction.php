<?php

namespace App\Controller;

use App\Entity\MediaObject;
use App\Entity\Product;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[AsController]
final class CreateProductAction extends AbstractController {

    public function __construct(private ProductsRepository $productsRepository) {
    }

    public function __invoke(Request $request): Product {
        $uploadedFile = $request->files->get('file');
        $content = $request->request->all();

        dd($content);
//        if (!$uploadedFile) {
//            throw new BadRequestHttpException('"file" is required');
//        }
//        if (!$product) {
//            throw new BadRequestHttpException('" product" is not found check id');
//        }

        $product = new Product($content);
        $product->file = $uploadedFile;

        return $product;
    }
}
