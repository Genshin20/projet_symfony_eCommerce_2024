<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function __construct(
    private UserPasswordHasherInterface $hasher
    ){}
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = (new User)
        ->setEmail('admin@test.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setFirstName('Philomene')
        ->setLastName('Faye')
        ->setTelephone('2020202020')
        ->setBirthDate(new \DateTime('20/02/1988'))
        ->setPassword(
            $this->hasher->hashPassword( new User, 'Test1234') 
        );
      

        $manager->persist($user);

        $manager->flush();
    }
}
