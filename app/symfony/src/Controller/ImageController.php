<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Vich\UploaderBundle\Storage\StorageInterface;

class ImageController extends AbstractController {


    public function __construct(private StorageInterface $storage, private ProductsRepository $productsRepository, private ParameterBagInterface $bag) {
    }

    /**
     * @Route("/images/products/{name}", name="index")
     */
    public function index(string $name, Request $request, Security $security) {

        if ($request->headers->get('hetic') !== $this->bag->get('lexik_jwt_authentication.pass_phrase')) {
            throw new AccessDeniedHttpException("access  ?? nan je quoi pas nhan");
        }

//        $object= $this->productsRepository->findBy(['image'=>$name]);
//        $file =$this->storage->resolveUri($object, 'file');

        $file = "../public/images/$name";
        return $this->file($file, 'product', ResponseHeaderBag::DISPOSITION_INLINE);
    }
}


