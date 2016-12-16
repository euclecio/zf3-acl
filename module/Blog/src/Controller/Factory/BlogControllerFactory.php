<?php

namespace Blog\Controller\Factory;

use Blog\Controller\BlogController;
use Blog\Entity\Post;
use Blog\Form\PostForm;
use Blog\Model\PostTable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Interop\Container\ContainerInterface;

class BlogControllerFactory
{

    public function __invoke(ContainerInterface $container)
    {

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $repository = $entityManager->getRepository(Post::class);
        $postForm = $container->get(PostForm::class);
        return new BlogController($entityManager, $repository, $postForm);
    }


}