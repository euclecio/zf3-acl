<?php

namespace Acl\Entity;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository 
{
    public function fetchParent($full = false)
    {
        $roles    = array();
        $entities = $this->findAll();
        foreach($entities as $entity)
            $roles[$entity->getId()] = $entity->getName();

        if(!$full)
        {
            unset($roles[1]); /* Visitante */
            unset($roles[5]); /* Developer */
        }

        return $roles;
    }
}