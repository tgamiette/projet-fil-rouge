<?php

namespace App\Controller\Test;

use App\Entity\OrderUser;
use App\Services\ProductsOrderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Validation de la commande avec vérifiation des objectif contrairement a l'autre qui permet juste l'ajout de commande payé
class ValideOrderController extends AbstractController {

    /**
     * @throws ORMException
     * @throws ORMException
     * @throws Exception
     */
    #[Route("/test/order/{id}/validate", name: "app_add_order_validate")]
    public function index($id, EntityManagerInterface $em, ProductsOrderHelper $productsOrderHelper): Response {

        $orderUserRepository = $em->getRepository(OrderUser::class);
        $orderUser = $orderUserRepository->find($id);

        $productsOrder = $orderUser ? $orderUser->getProductsOrders() : throw new Exception("Order user n'existe pas");

        foreach ($productsOrder as $ProductOrder) {
            $productsOrderHelper->validateObjective($ProductOrder);
        }

        return $this->render('add_order_paid/index.html.twig', [
            'controller_name' => 'AddOrderPaidController',
        ]);
    }
}
