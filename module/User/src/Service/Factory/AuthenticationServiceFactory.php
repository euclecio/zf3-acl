<?php

namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Db\Adapter\AdapterInterface;

class AuthenticationServiceFactory
{

    public function __invoke(ContainerInterface $container)
    {
        return $container->get('doctrine.authenticationservice.orm_default');
    }


}