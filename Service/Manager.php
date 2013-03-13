<?php

namespace MP\Bundle\CatalogBundle\Service;

use MP\Bundle\CatalogBundle\Entity\Product;
use MP\Bundle\CatalogBundle\Entity\ProductOwner;
use MP\Bundle\CatalogBundle\Model\ProductOwnerInterface;

class Manager
{
	protected $em;

	public function __construct($em)
	{
		$this->em = $em;
	}

	public function getEntityManager()
	{
		return $this->em;
	}

	/**
     * Is a proxy class
     *
     * @param ReflectionClass $reflection
     * @return boolean
     */
    public static function isProxyClass(\ReflectionClass $reflection)
    {
        return in_array('Doctrine\ORM\Proxy\Proxy', array_keys($reflection->getInterfaces()));
    }

    /**
     * Retrieve the classname for a given ProductOwnerInterface
     *
     * @param ProductOwnerInterface $product_owner_interface
     * @return string
     */
    public function getClassName(ProductOwnerInterface $product_owner_interface)
    {
        $reflection = new \ReflectionClass($product_owner_interface);

        if(self::isProxyClass($reflection) && $reflection->getParentClass()) {
            $reflection = $reflection->getParentClass();
        }

        return $reflection->getName();
    }

    /**
     * Get Hash for a given object which mush implement ProductOwnerInterface
     *
     * @param ProductOwnerInterface $product_owner_interface
     * @return string The generated hash
     */
    public function getHash(ProductOwnerInterface $product_owner_interface)
    {
        $raw = sprintf('%s_%s',
            $this->getClassName($product_owner_interface),
            $product_owner_interface->getId()
        );

        return md5($raw);
    }

	public function attachProductToOwner(Product $product, ProductOwnerInterface $product_owner_interface)
	{
		$productOwner = new ProductOwner();
		$productOwner
			->setName($product_owner_interface->getName())
			->setAddress($product_owner_interface->getAddress())
			->setPostCode($product_owner_interface->getPostCode())
			->setCity($product_owner_interface->getCity())
			->setCountry($product_owner_interface->getCountry())
			->setPhone($product_owner_interface->getPhone())
			->setMail($product_owner_interface->getEmail())
			->setOwnerId($product_owner_interface->getId())
			->setOwnerClass($this->getClassName($product_owner_interface))
			->setOwnerHash($this->getHash($product_owner_interface))
		;

		$product->setOwner($productOwner);

		return $product;
	}

	public function createProductOwner(ProductOwnerInterface $product_owner_interface)
	{
		$productOwner = new ProductOwner();
		$productOwner
			->setName($product_owner_interface->getName())
			->setAddress($product_owner_interface->getAddress())
			->setPostCode($product_owner_interface->getPostCode())
			->setCity($product_owner_interface->getCity())
			->setCountry($product_owner_interface->getCountry())
			->setPhone($product_owner_interface->getPhone())
			->setMail($product_owner_interface->getEmail())
			->setOwnerId($product_owner_interface->getId())
			->setOwnerClass($this->getClassName($product_owner_interface))
			->setOwnerHash($this->getHash($product_owner_interface))
		;
		$this->getEntityManager()->persist($productOwner);
		$this->getEntityManager()->flush();

		return $productOwner;
	}

	public function getAttachedProductOwner(ProductOwnerInterface $product_owner_interface)
	{
		return $this->getEntityManager()
			->getRepository('MPCatalogBundle:ProductOwner')
			->findOneBy(array(
				'ownerHash' => $this->getHash($product_owner_interface)
			))
		;
	}
}