<?php

namespace MP\Bundle\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="mp__category")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    protected $color;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $level;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $tree;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
     */
    protected $products;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $parent;    

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * hasParent
     *
     * @return boolean
     */
    public function hasParent()
    {
        return null !== $this->getParent();
    }

    /**
     * countLevel
     *
     * @return integer
     */
    public function countLevel()
    {
        if(!$this->hasParent()) {
            return 0;
        }

        return $this->getParent()->getLevel() + 1;
    }

    /**
     * updateLevel
     *
     * @return boolean
     */
    public function updateLevel()
    {
        $level = $this->getLevel();
        $this->setLevel($this->countLevel());

        return $level != $this->getLevel();
    }

    /**
     * onUpdate
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function onUpdate()
    {
        $this->updateLevel();
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
     * @return Category
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
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add product
     *
     * @param \MP\Bundle\CatalogBundle\Entity\Product $product
     * @return Category
     */
    public function addProduct(\MP\Bundle\CatalogBundle\Entity\Product $product)
    {
        $this->products[] = $product;
    
        return $this;
    }

    /**
     * Remove product
     *
     * @param \MP\Bundle\CatalogBundle\Entity\Product $product
     */
    public function removeProduct(\MP\Bundle\CatalogBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Category
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Category
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set tree
     *
     * @param string $tree
     * @return Category
     */
    public function setTree($tree)
    {
        $this->tree = $tree;
    
        return $this;
    }

    /**
     * Get tree
     *
     * @return string 
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Add children
     *
     * @param \MP\Bundle\CatalogBundle\Entity\Category $children
     * @return Category
     */
    public function addChildren(\MP\Bundle\CatalogBundle\Entity\Category $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \MP\Bundle\CatalogBundle\Entity\Category $children
     */
    public function removeChildren(\MP\Bundle\CatalogBundle\Entity\Category $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \MP\Bundle\CatalogBundle\Entity\Category $parent
     * @return Category
     */
    public function setParent(\MP\Bundle\CatalogBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \MP\Bundle\CatalogBundle\Entity\Category 
     */
    public function getParent()
    {
        return $this->parent;
    }
}