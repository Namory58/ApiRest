<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for($i=0;$i<6;$i++){
            $user = new User();
            $user->setEmail('testUser'.$i.'@gmail.com');
            $user->setPassword($this->userPasswordHasher->hashPassword($user,'password'));
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
