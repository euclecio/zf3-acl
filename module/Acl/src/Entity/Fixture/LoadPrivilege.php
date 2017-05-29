<?php

namespace Acl\Entity\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Acl\Entity\Privilege;

/**
 * @author Euclécio Josias Rodrigues <eucjosias@gmail.com>
 */
class LoadPrivilege extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $visitor   = $manager->getReference(\Acl\Entity\Role::class, 1);
        $admin     = $manager->getReference(\Acl\Entity\Role::class, 2);
        $developer = $manager->getReference(\Acl\Entity\Role::class, 3);

        $aclRole      = $manager->getReference(\Acl\Entity\Resource::class, 1);
        $aclResource  = $manager->getReference(\Acl\Entity\Resource::class, 2);
        $aclPrivi     = $manager->getReference(\Acl\Entity\Resource::class, 3);
        $k13          = $manager->getReference(\Acl\Entity\Resource::class, 4);
        $auth         = $manager->getReference(\Acl\Entity\Resource::class, 5);
        $userResource = $manager->getReference(\Acl\Entity\Resource::class, 6);
        $blog         = $manager->getReference(\Acl\Entity\Resource::class, 7);

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
