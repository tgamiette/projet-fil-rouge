<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Delivery;
use App\Entity\OrderSeller;
use App\Entity\OrderUser;
use App\Entity\Place;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture {
    protected $slugger;
    protected $password;
    protected $userPasswordHasher;
    protected $encoder;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $encoder, PasswordHasherFactoryInterface $passwordHasherFactory) {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void {
        $faker = Factory::create('fr_FR');
        $admin = new User();
        $hash = $this->encoder->hashPassword($admin, "password");
        $admin->setEmail("admin@gmail.com");
        $admin->setPassword($hash);
        $admin->setFullName("Admin");
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $n = 0;
        for ($u = 0; $u < 5; $u++) {
            $place = new Place();
            $place->setVille($faker->city())
                ->setAdress($faker->address());
            $manager->persist($place);
        }


        for ($u = 0; $u < 10; $u++) {
            $user = new User();
            $hash = $this->encoder->hashPassword($user, "password");
            $user->setEmail("seller$u@gmail.com")
                ->setFullName($faker->name())
                ->setPassword($hash);
            $manager->persist($user);

            $category = new Category();
            $category->setTitle($faker->sentence(5));
            $manager->persist($category);

            for ($p = 0; $p < 5; $p++) {
                $product = new Product();
                $product->setTitle($faker->sentence(4))
                    ->setPrice($faker->randomFloat(2, 30, 100))
                    ->setDescription($faker->paragraph(5))
                    ->setCategory($category)
                    ->setSeller($user)
                    ->setQuantity(100);
                $manager->persist($product);

                $orderSeller = new OrderSeller();
                $orderSeller->setProduct($product)
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-3 months', 'now')))
                    ->setQuantity(5)
                    ->setTotal(5 * $product->getPrice());
                $manager->persist($orderSeller);

                for ($T = 1; $T < 4; $T++) {
                    $users = new User();
                    $n++;
                    $hash = $this->encoder->hashPassword($users, "password");
                    $users->setEmail("user$n@gmail.com")
                        ->setFullName($faker->name())
                        ->setPassword($hash)
                        ->setRoles(['ROLE_USER']);
                    $manager->persist($users);
//
                    $orderUser = new OrderUser();
                    $orderUser->setDate(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-3 months', 'now')))
                        ->setProduct($product)
                        ->setOrderSeller($orderSeller)
                        ->setCustomer($users)
                        ->setTotal($product->getPrice());

                    $manager->persist($orderUser);
                }
                var_dump($p);
            }
        }

        $manager->flush();
    }
}
