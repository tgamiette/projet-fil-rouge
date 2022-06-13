<?php

namespace App\Controller;

use App\Entity\OrderUser;
use App\Entity\User;
use App\Repository\OrderUserRepository;
use Stripe\PaymentIntent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{



    /**
    * @Route("/", name="index")
    */
    public function index(OrderUserRepository $orderUserRepository){

//$orderUserRepository->find()

//        $payment= PaymentIntent::retrieve('r');
//        $payment->
        return $this->render('index.html.twig');
    }
}
