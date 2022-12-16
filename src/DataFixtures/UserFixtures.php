<?php

namespace App\UserFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userEncoderInterface) {}

    public function load(ObjectManager $manager): void
    {
        $admin = (new User())->setEmail('admin@gmail.com')->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN', 'ROLE_USER']);
        $user1 = (new User())->setEmail('user@gmail.com')->setRoles(['ROLE_USER']);
        
        for ($i=1; $i < 10; $i++) { 
            $user[$i] = (new User())->setEmail('user'. $i .'@gmail.com')->setRoles(['ROLE_USER', 'ROLE_SUPER_ADMIN']);   
            $user[$i]->setPassword($this->userEncoderInterface->hashPassword($user[$i], 'test1234'));
            $manager->persist($user[$i]);
        }

        $admin->setPassword($this->userEncoderInterface->hashPassword($admin, 'test1234'));
        $user1->setPassword($this->userEncoderInterface->hashPassword($user1, 'test1234'));

        $manager->persist($admin);
        $manager->persist($user1);

        $manager->flush();
    }
}
