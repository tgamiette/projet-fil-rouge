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

class ImageController extends AbstractController {


    public function __construct(private $secretKey, private ProductsRepository $productsRepository, private ParameterBagInterface $bag) {
    }

    /**
     * @Route("/image/{id}", name="index")
     */
    public function index(string $id, Request $request, Security $security) {

        if ($request->headers->get('hetic') !== $_ENV['JWT_PASSPHRASE']) {
            throw new AccessDeniedHttpException("access ??");
        }

        dd($this->getParameter('upload_destination'));
        $this->productsRepository->findBy();

        $this->storage->resolveUri($object, 'file');

        $file = "../public/images/$id";
        return $this->file($file, 'product', ResponseHeaderBag::DISPOSITION_INLINE);
    }
}


