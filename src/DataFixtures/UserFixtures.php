<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    //Function pour venir encoder (hasher) le Mot de passe avant son stockage
    public function __construct(private UserPasswordHasherInterface $hasher){

    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@email.com');
        $admin->setPseudo('boss');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $john= new User();
        $john->setEmail('john@gmail.com');
        $john->setPseudo('tester');
        $john->setPassword($this->hasher->hashPassword($john, 'john'));;
        $manager->persist($john);

        $manager->flush();
    }
}
