<?php

namespace App\Controller;

use App\Entity\Purchase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidatePurchase extends AbstractController {
    private Purchase $purchase;

    public function __construct() {
    }
//TODO il faut  marquer le statut de la commande
    public function __invoke(Purchase $data): Purchase {

        return $data;
    }
}
