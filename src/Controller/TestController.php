<?php

namespace App\Controller;

use Doctrine\DBAL\Types\DateImmutableType;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/', name: 'test')]
    public function index(): Response
    {
        $faker= Factory::create('fr_FR');
        $date= $faker->date('Y-m-d H:i:s');
        $date= $faker->dateTime();
        $date= $faker->dateTimeBetween('-2 months', 'now');
        $date2 = new \DateTime();
        var_dump($date,$date2);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }
}
