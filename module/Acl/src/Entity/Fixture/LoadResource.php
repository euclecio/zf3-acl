<?php

namespace Acl\Entity\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Acl\Entity\Resource;

class LoadResource extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $resource = new Resource;
        $resource->setName("Acl\Controller\Role");
        $manager->persist($resource);

        $resource = new Resource;
        $resource->setName("Acl\Controller\Resource");
        $manager->persist($resource);

        $resource = new Resource;
        $resource->setName("Acl\Controller\Privilege");
        $manager->persist($resource);

        $resource = new Resource;
        $resource->setName("K13\Controller\Index");
        $manager->persist($resource);

        $resource = new Resource;
        $resource->setName("K13User\Controller\Auth");
        $manager->persist($resource);

        $resource = new Resource;
        $resource->setName("K13User\Controller\Index");
        $manager->persist($resource);

        $resource = new Resource;
        $resource->setName("Blog\Controller\BlogController");
        $manager->persist($resource);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
