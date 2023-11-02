<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setEmail('email'.$i.'@email.com');
            $user->setPassword('123456');
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);

            $this->addReference('user-'.$i, $user);
        }

        $manager->flush();
    }
}