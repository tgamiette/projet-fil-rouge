<?php

namespace App\DataFixtures;

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

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher, PasswordHasherFactoryInterface $passwordHasherFactory) {
        $this->slugger = $slugger;
        $userPasswordHasher->
        $passwordHasherFactory->getPasswordHasher();
}


    public function load(ObjectManager $manager): void {
        $faker = Factory::create('fr_FR');


        $admin = new User();
        $admin->setEmail("admin@gmail.com");
        $admin->setPassword("Password");
        $admin->setFullName("Admin");
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for ($u = 0; $u < 5; $u++) {
            $user = new User();
            $user->setEmail("user$u@gmail.com")
                ->setFullName($faker->name())
                ->setPassword("Paswword");

            $manager->persist($user);

        }
        // $product  = new Product();
        // $manager->persist($product);

        {
            $manager->flush();
        }
    }
}
