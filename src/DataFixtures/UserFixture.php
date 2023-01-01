<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('Fixture user for unit testing');
        $user->setEmail('fixturetest@demosymfony.com');
        $user->setStatus(User::STATUS_ACTIVE);
        $user->setAddress('Fixture Avenue');

        $manager->persist($user);
        $manager->flush();
    }
}
