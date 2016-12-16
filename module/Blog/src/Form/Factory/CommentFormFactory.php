<?php

namespace Blog\Form\Factory;

use Blog\Entity\Comment;
use Blog\Form\CommentForm;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

class CommentFormFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $form = new CommentForm();
        $form->setHydrator(new ClassMethods());
        $form->setObject(new Comment());
        return $form;
    }


}