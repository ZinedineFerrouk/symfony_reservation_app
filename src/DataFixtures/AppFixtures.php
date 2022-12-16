<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    // public function __construct(private UserPasswordHasherInterface $userEncoderInterface) {}

    public function load(ObjectManager $manager): void
    {
        // $admin = (new User())->setEmail('admin@gmail.com')->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN', 'ROLE_USER']);
        // $user1 = (new User())->setEmail('user@gmail.com')->setRoles(['ROLE_USER']);
        
        // for ($i=1; $i < 10; $i++) { 
        //     $user[$i] = (new User())->setEmail('user'. $i .'@gmail.com')->setRoles(['ROLE_USER', 'ROLE_SUPER_ADMIN']);   
        //     $user[$i]->setPassword($this->userEncoderInterface->hashPassword($user[$i], 'test1234'));
        //     $manager->persist($user[$i]);
        // }

        // $admin->setPassword($this->userEncoderInterface->hashPassword($admin, 'test1234'));
        // $user1->setPassword($this->userEncoderInterface->hashPassword($user1, 'test1234'));

        // $manager->persist($admin);
        // $manager->persist($user1);

        // $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
