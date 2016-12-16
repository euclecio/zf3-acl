<?php

namespace Acl\Entity\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Acl\Entity\Role;

class LoadRole extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $role = new Role;
        $role->setName("Visitante");
        $manager->persist($role);

        $visitor = $manager->getReference(\Acl\Entity\Role::class, 1);

        $role = new Role;
        $role->setName("Administrador")
             ->setParent($visitor)
             ->setLayout("layout/default")
             ->setRedirect("user-index");
        $manager->persist($role);

        $role = new Role;
        $role->setName("Developer")
             ->setDeveloper(1)
             ->setLayout("layout/default")
             ->setRedirect("acl-dev");
        $manager->persist($role);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
