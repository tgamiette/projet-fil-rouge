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
    protected $userPasswordHasher;
    protected $encoder;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $encoder, PasswordHasherFactoryInterface $passwordHasherFactory) {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void {
        $faker = Factory::create('fr_FR');

        $admin = new User();
        $hash= $this->encoder->hashPassword($admin,"password");
        $admin->setEmail("admin@gmail.com");
        $admin->setPassword($hash);
        $admin->setFullName("Admin");
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for ($u = 0; $u < 5; $u++) {
            $user = new User();
            $hash= $this->encoder->hashPassword($user,"password");

            $user->setEmail("user$u@gmail.com")
                ->setFullName($faker->name())
                ->setPassword($hash);

            $manager->persist($user);

        }
        // $product  = new Product();
        // $manager->persist($product);

        {
            $manager->flush();
        }
    }
}
