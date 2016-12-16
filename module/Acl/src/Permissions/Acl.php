<?php

namespace Acl\Permissions;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\Stdlib\Exception\RuntimeException;

class Acl extends ZendAcl
{
    /**
     * @var array
     */
    protected $roles = [];

    /**
     * @var array
     */
    protected $resources = [];

    /**
     * @var array
     */
    protected $privileges = [];

    /**
     * @param Array $role
     * @param Array $resource
     * @param Array $privilege
     */
    public function __construct(array $roles, array $resources, array $privileges)
    {
        $this->roles      = $roles;
        $this->resources  = $resources;
        $this->privileges = $privileges;

        $this->loadRoles()
             ->loadResources()
             ->loadPrivileges();
    }

    /**
     * Load Roles from factory
     * @return $this
     */
    protected function loadRoles()
    {
        foreach($this->roles as $role) {
            if($role->getParent()) 
                $this->addRole(new Role($role->getName()), new Role($role->getParent()->getName()));
            else
                $this->addRole(new Role($role->getName()));

            if($role->getDeveloper())
                $this->allow($role->getName(), array(), array());
        }

        return $this;
    }

    /**
     * Load Resources from factory
     * @return $this
     */
    protected function loadResources()
    {
        foreach($this->resources as $resource) 
            $this->addResource(new Resource($resource->getName()));

        return $this;
    }

    /**
     * Load Privileges from factory
     * @return $this
     */
    protected function loadPrivileges()
    {
        foreach($this->privileges as $privilege) {
            /* All actions from resource or just the actions that are allowed to the role */
            if($privilege->getPermissions() === 'All') {
                $this->allow($privilege->getRole()->getName(), $privilege->getResource()->getName(), array());
            } else {
                $actions = json_decode($privilege->getPermissions(), true);
                $this->allow($privilege->getRole()->getName(), $privilege->getResource()->getName(), $actions);
            }
        }

        return $this;
    }

    /**
     * @param  Zend\Permissions\Acl\Role\RoleInterface|string $role
     * @param  Zend\Permissions\Acl\Resource\ResourceInterface|string $resource
     * @param  string $privilege
     * @return bool
     */
    public function isAllowed($role = null, $resource = null, $privilege = null)
    {
        if (!$this->hasRole($role)) {
            return false;
        }

        if (!$this->hasResource($resource)) {
            return false;
        }

        return parent::isAllowed($role, $resource, $privilege);
    }
}