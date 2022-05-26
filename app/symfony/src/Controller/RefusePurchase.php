<?php

namespace App\Controller;

use App\Entity\Purchase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RefusePurchase extends AbstractController {
    private Purchase $purchase;

    public function __construct() {
    }

//TODO il faut  marquer le statut de la commande
    public function __invoke(Purchase $data): Purchase {

        return $data;
    }

}
