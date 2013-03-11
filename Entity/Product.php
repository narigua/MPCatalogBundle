<?php

namespace MP\Bundle\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="mp__product")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"product" = "Product", "downloadable" = "DownloadableProduct"})
 */
class Product
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
     * @ORM\Column(type="decimal", scale=2, name="wholesaleprice")
     */
    protected $wholeSalePrice;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $ean;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $reference;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isEnabled;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="products")
     * @ORM\JoinTable(name="mp__product_category",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     **/
    protected $categories;

    /**
     * @ORM\ManyToOne(targetEntity="ProductOwner", inversedBy="products")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $owner;

    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="products")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $brand;

    /**
     * @ORM\OneToMany(targetEntity="Feature", mappedBy="product")
     */
    protected $features;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    public function __toString()
    {
        return $this->getName();
    }
    
    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
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
     * @return Product
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
     * Set wholeSalePrice
     *
     * @param float $wholeSalePrice
     * @return Product
     */
    public function setWholeSalePrice($wholeSalePrice)
    {
        $this->wholeSalePrice = $wholeSalePrice;
    
        return $this;
    }

    /**
     * Get wholeSalePrice
     *
     * @return float 
     */
    public function getWholeSalePrice()
    {
        return $this->wholeSalePrice;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
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
     * Set category
     *
     * @param MP\Bundle\CatalogBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(MP\Bundle\CatalogBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return MP\Bundle\CatalogBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set ean
     *
     * @param string $ean
     * @return Product
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
    
        return $this;
    }

    /**
     * Get ean
     *
     * @return string 
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Product
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->features = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     * @return Product
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    
        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean 
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Add categories
     *
     * @param MP\Bundle\CatalogBundle\Entity\Category $categories
     * @return Product
     */
    public function addCategorie(MP\Bundle\CatalogBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param MP\Bundle\CatalogBundle\Entity\Category $categories
     */
    public function removeCategorie(MP\Bundle\CatalogBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set owner
     *
     * @param MP\Bundle\CatalogBundle\Entity\ProductOwner $owner
     * @return Product
     */
    public function setOwner(MP\Bundle\CatalogBundle\Entity\ProductOwner $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return MP\Bundle\CatalogBundle\Entity\ProductOwner 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set brand
     *
     * @param MP\Bundle\CatalogBundle\Entity\Brand $brand
     * @return Product
     */
    public function setBrand(MP\Bundle\CatalogBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return MP\Bundle\CatalogBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add features
     *
     * @param MP\Bundle\CatalogBundle\Entity\Feature $features
     * @return Product
     */
    public function addFeature(MP\Bundle\CatalogBundle\Entity\Feature $features)
    {
        $this->features[] = $features;
    
        return $this;
    }

    /**
     * Remove features
     *
     * @param MP\Bundle\CatalogBundle\Entity\Feature $features
     */
    public function removeFeature(MP\Bundle\CatalogBundle\Entity\Feature $features)
    {
        $this->features->removeElement($features);
    }

    /**
     * Get features
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}