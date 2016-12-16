<?php

namespace Acl\Entity;

use Doctrine\ORM\EntityRepository;

class ResourceRepository extends EntityRepository {

    public function fetchPairs()
    {
        $entities = $this->findAll();
        $array = array();
        foreach($entities as $entity)
            $array[$entity->getId()] = $entity->getName();
        
        return $array;
    }
    
}
