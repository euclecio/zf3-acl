<?php

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
// use Zend\Stdlib\Hydrator;

/**
 * Role
 *
 * @ORM\Table(name="acl_role")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Acl\Entity\RoleRepository")
 */
class Role
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="layout", type="string", length=255, nullable=true)
     */
    private $layout;

    /**
     * @var string
     *
     * @ORM\Column(name="redirect", type="string", length=255, nullable=true)
     */
    private $redirect;

    /**
     * @var boolean
     *
     * @ORM\Column(name="developer", type="boolean", nullable=false)
     */
    private $developer = false;

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
     * @var \Acl\Entity\AclRole
     *
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     * })
     */
    private $parent;

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
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set layout
     *
     * @param string $layout
     * @return Role
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get layout
     *
     * @return string 
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set redirect
     *
     * @param string $redirect
     * @return Role
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;

        return $this;
    }

    /**
     * Get redirect
     *
     * @return string 
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * Set developer
     *
     * @param boolean $developer
     * @return Role
     */
    public function setDeveloper($developer)
    {
        $this->developer = $developer;

        return $this;
    }

    /**
     * Get developer
     *
     * @return boolean 
     */
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Role
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
     * @return Role
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
     * Set parent
     *
     * @param \Acl\Entity\Role $parent
     * @return Role
     */
    public function setParent(\Acl\Entity\Role $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Acl\Entity\Role 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /*
     * toArray
     */
    public function toArray()
    {
        if(isset($this->parent))
            $parent = $this->parent->getId();
        else 
            $parent = false;
        
        return array(
            'id'        => $this->id,
            'name'      => $this->name,
            'layout'    => $this->layout,
            'redirect'  => $this->redirect,
            'developer' => $this->developer,
            'parent'    => $parent
        );
    }
}
