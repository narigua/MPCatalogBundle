<?php

namespace MP\Bundle\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="mp__product_downloadable")
 */
class DownloadableProduct extends Product
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $token;

    public function generateToken()
    {
        $date = new \DateTime();

        return md5(sprintf("%s %d %s",
            $this->getName(),
            $this->getId(),
            $date->format("Ymd")
        ));
    }

    /**
     * onCreate
     *
     * @ORM\PrePersist()
     */
    public function onCreate()
    {
        $this->setToken($this->generateToken());
    }

    /**
     * Set token
     *
     * @param string $token
     * @return DownloadableProduct
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
}