<?php

namespace Blog\Form\Factory;

use Blog\Entity\Post;
use Blog\Form\PostForm;
use Blog\InputFilter\PostInputFilter;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

class PostFormFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new PostInputFilter();
        $form = new PostForm();
        $form->setInputFilter($inputFilter);
        $form->setHydrator(new ClassMethods());
        $form->setObject(new Post());
        return $form;
    }


}