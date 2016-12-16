<?php

namespace Acl\Entity\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use User\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $visitor   = $manager->getReference(\Acl\Entity\Role::class, 1);
        $admin     = $manager->getReference(\Acl\Entity\Role::class, 2);
        $developer = $manager->getReference(\Acl\Entity\Role::class, 3);

        $user = new User();
        $user->setUsername("luizcarlos@schoolofnet.com")
            ->setFullName("Luiz Diniz")
            ->setRole($admin)
            ->setPassword(password_hash('123456',PASSWORD_DEFAULT));
        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
