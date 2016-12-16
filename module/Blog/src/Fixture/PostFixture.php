<?php

namespace Blog\Fixture;

use Blog\Entity\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PostFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface  {

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (range(1,20) as $value){
            $post = new Post();
            $post->setTitle("Title $value")
                ->setContent("<p>Content $value</p>");
            $manager->persist($post);
            $this->addReference("post-$value", $post);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 10;
    }
}

