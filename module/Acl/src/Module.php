<?php

namespace Acl;

/**
 * Class Module
 * @package Acl
 */
class Module
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                Permissions\Acl::class => function($container) {
                    /* Get ACL from database */
					$em         = $container->get(\Doctrine\ORM\EntityManager::class);
					$roles      = $em->getRepository("Acl\Entity\Role")->findAll();
					$resources  = $em->getRepository("Acl\Entity\Resource")->findAll();
					$privileges = $em->getRepository("Acl\Entity\Privilege")->findAll();

                    return new Permissions\Acl($roles, $resources, $privileges);
                }
            )  
        );
    }
}