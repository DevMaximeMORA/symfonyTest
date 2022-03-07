<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;

class UserFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setUsername("admin");
        $admin->setPassword($this->encoder->encodePassword($admin, "password"));
        $admin->setRoles( array('ROLE_ADMIN') );
        $manager->persist($admin);

        for($i = 0; $i < 10; $i++)
        {
            $user = new User();
            $user->setUsername("user-".$i);
            $user->setPassword($this->encoder->encodePassword($user, "password"));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
