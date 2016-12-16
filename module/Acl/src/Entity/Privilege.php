<?php

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
// use Zend\Stdlib\Hydrator;

/**
 * Privilege
 *
 * @ORM\Table(name="acl_privilege")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Acl\Entity\PrivilegeRepository")
 */
class Privilege
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="permissions", type="text", nullable=false)
     */
    private $permissions;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @var \Acl\Entity\AclResource
     *
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Resource")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="resource_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * })
     */
    private $resource;

    /**
     * @var \Acl\Entity\AclRole
     *
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * })
     */
    private $role;

    /**
     * Constructor
     */
    public function __construct($options = array())
    {
        // $hydrator = new Hydrator\ClassMethods();
        // $hydrator->hydrate($options, $this);

        $this->created = new \DateTime("now");
        $this->updated = new \DateTime("now");
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set permissions
     *
     * @param string $permissions
     * @return Privilege
     */
    public function setPermissions($permissions)
    {
        if(is_array($permissions))
            $this->permissions = json_encode($permissions);
        else
            $this->permissions = $permissions;

        return $this;
    }

    /**
     * Get permissions
     *
     * @return string 
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Privilege
     */
    public function setCreated()
    {
        $this->created = new \DateTime("now");

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @ORM\PrePersist
     * @param \DateTime $updated
     * @return Privilege
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime("now");

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set resource
     *
     * @param \Acl\Entity\Resource $resource
     * @return Privilege
     */
    public function setResource(\Acl\Entity\Resource $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return \Acl\Entity\Resource 
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set role
     *
     * @param \Acl\Entity\Role $role
     * @return Privilege
     */
    public function setRole(\Acl\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Acl\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }

    /*
     * toArray
     */
    public function toArray()
    {
        return array(
            'id'       => $this->id,
            'name'     => $this->name,
            'role'     => $this->role->getId(),
            'resource' => $this->resource->getId()
        );
    }
}
