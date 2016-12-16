<?php

namespace Acl\Entity\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Acl\Entity\Privilege;

class LoadPrivilege extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $visitor   = $manager->getReference('Acl\Entity\Role', 1);
        $admin     = $manager->getReference('Acl\Entity\Role', 2);
        $developer = $manager->getReference('Acl\Entity\Role', 3);

        $aclRole      = $manager->getReference('Acl\Entity\Resource', 1);
        $aclResource  = $manager->getReference('Acl\Entity\Resource', 2);
        $aclPrivi     = $manager->getReference('Acl\Entity\Resource', 3);
        $k13          = $manager->getReference('Acl\Entity\Resource', 4);
        $auth         = $manager->getReference('Acl\Entity\Resource', 5);
        $userResource = $manager->getReference('Acl\Entity\Resource', 6);
        $blog         = $manager->getReference('Acl\Entity\Resource', 7);

        /* Visitor */
        $privilege = new Privilege;
        $privilege->setPermissions("All")
                  ->setRole($visitor)
                  ->setResource($auth);
        $manager->persist($privilege);
        /* Visitor */

        /* Administrator */
        $privilege = new Privilege;
        $privilege->setPermissions(['index', 'edit'])
                  ->setRole($admin)
                  ->setResource($blog);
        $manager->persist($privilege);
        /* Administrator */

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}