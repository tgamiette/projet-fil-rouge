<?php

namespace App\Controller\Test;

use App\Entity\OrderUser;
use App\Entity\Product;
use App\Entity\ProductsOrder;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AddOrderPaidController extends AbstractController {

    #[Route('/test/order/paid', name: 'app_add_order_paid')]
    public function index(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= rand(1, 5); $i++) {
            $user = new User();
            $order = new OrderUser();
            $productRepository = $em->getRepository(Product::class);
            $product = $productRepository->find(123);
            $hash = $passwordHasher->hashPassword($user, 'test');
            $user
                ->setEmail($faker->email())
                ->setPassword($hash)
                ->setFullName($faker->name());
            $order->setBuyer($user)
                ->setTotal(6666);
            //pour chaque productOrder
            for ($i = 0; $i <= rand(1, 5); $i++) {
                $productOrder = new ProductsOrder();
                $productOrder->setOrder($order)
                    ->setProduct($product)
                    ->setQuantity(rand(2, 5))
                    ->setTotal(rand(10, 100))
                    ->setStatus(ProductsOrder::STATUT_PAID)
                    ->setPrixU(1)->setUnit(1);
                $order->addProductsOrder($productOrder);

                $em->persist($productOrder);
            }
            $em->persist($user);
            $em->persist($order);

            $em->flush();
        }


        return $this->render('add_order_paid/index.html.twig', [
            'controller_name' => 'AddOrderPaidController',
        ]);

    }
}
