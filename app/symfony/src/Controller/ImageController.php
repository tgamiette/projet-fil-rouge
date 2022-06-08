<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ImageController extends AbstractController{

    /**
    * @Route("/image/{id}", name="index")
    */
    public function index(string $id){
        return $this->render('index.html.twig');
//        $user =new User();
//        $user->g

    }
}

?>
