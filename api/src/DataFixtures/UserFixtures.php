<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // pwd = test
        $pwd = '$2y$13$HU6SFNv3ZsN.1r3bLUZeueliGnneUXnNmiLMaAMYhlVSL/7X9XAF6';

        $user = (new User())
            ->setEmail('user@user.fr')
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setPassword($pwd);
        $manager->persist($user);

        $user = (new User())
            ->setEmail('director_old@user.fr')
            ->setRoles(['ROLE_DIRECTOR'])
            ->setCreatedAt(new \DateTimeImmutable('-6 month'))
            ->setPassword($pwd);
        $manager->persist($user);

        $user = (new User())
            ->setEmail('director_new@user.fr')
            ->setRoles(['ROLE_DIRECTOR'])
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setPassword($pwd);
        $manager->persist($user);

        $user = (new User())
            ->setEmail('admin@user.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setPassword($pwd);
        $manager->persist($user);

        $manager->flush();
    }
}
