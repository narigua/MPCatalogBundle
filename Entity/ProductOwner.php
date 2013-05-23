<?php

namespace MP\Bundle\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="mp__product_owner")
 */
class ProductOwner
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
     * @ORM\Column(type="string", length=255)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=100, name="postcode")
     */
    protected $postCode;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $country;

    /**
     * @ORM\Column(type="string", length=24)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $mail;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="owner")
     */
    protected $products;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $ownerClass;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $ownerId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $ownerHash;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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
     * @return ProductOwner
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
     * Set address
     *
     * @param string $address
     * @return ProductOwner
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     * @return ProductOwner
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    
        return $this;
    }

    /**
     * Get postCode
     *
     * @return string 
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ProductOwner
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return ProductOwner
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return ProductOwner
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return ProductOwner
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    
        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Add products
     *
     * @param \MP\Bundle\CatalogBundle\Entity\Product $products
     * @return ProductOwner
     */
    public function addProduct(\MP\Bundle\CatalogBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param \MP\Bundle\CatalogBundle\Entity\Product $products
     */
    public function removeProduct(\MP\Bundle\CatalogBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
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
     * Set ownerClass
     *
     * @param string $ownerClass
     * @return ProductOwner
     */
    public function setOwnerClass($ownerClass)
    {
        $this->ownerClass = $ownerClass;
    
        return $this;
    }

    /**
     * Get ownerClass
     *
     * @return string 
     */
    public function getOwnerClass()
    {
        return $this->ownerClass;
    }

    /**
     * Set ownerId
     *
     * @param string $ownerId
     * @return ProductOwner
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    
        return $this;
    }

    /**
     * Get ownerId
     *
     * @return string 
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * Set ownerHash
     *
     * @param string $ownerHash
     * @return ProductOwner
     */
    public function setOwnerHash($ownerHash)
    {
        $this->ownerHash = $ownerHash;
    
        return $this;
    }

    /**
     * Get ownerHash
     *
     * @return string 
     */
    public function getOwnerHash()
    {
        return $this->ownerHash;
    }
}