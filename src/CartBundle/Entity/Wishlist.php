<?php

namespace CartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Wishlist
 *
 * @ORM\Table(name="wishlist")
 * @ORM\Entity(repositoryClass="CartBundle\Repository\CartRepository")
 */
class Wishlist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="prod_name", type="string", length=50, nullable=false)
     */
    private $prodName;
    /**
     * @var string
     *
         * @ORM\Column(name="voucher", type="string", length=200, nullable=true)
     */
    private $voucher;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="email_client", type="string", length=100, nullable=false)
     */
    private $emailClient;

    /**
     * @var float
     *
     * @ORM\Column(name="prod_price", type="float", precision=10, scale=0, nullable=false)
     */
    private $prodPrice;



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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * Get voucher
     *
     * @return string
     */
    public function getVoucher()
    {
        return $this->voucher;
    }

    /**
     * @param int $voucher
     */
    public function setVoucher($voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Set prodName
     *
     * @param string $prodName
     *
     * @return Wishlist
     */
    public function setProdName($prodName)
    {
        $this->prodName = $prodName;

        return $this;
    }

    /**
     * Get prodName
     *
     * @return string
     */
    public function getProdName()
    {
        return $this->prodName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Wishlist
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
     * Set emailClient
     *
     * @param string $emailClient
     *
     * @return Wishlist
     */
    public function setEmailClient($emailClient)
    {
        $this->emailClient = $emailClient;

        return $this;
    }

    /**
     * Get emailClient
     *
     * @return string
     */
    public function getEmailClient()
    {
        return $this->emailClient;
    }

    /**
     * Set prodPrice
     *
     * @param float $prodPrice
     *
     * @return Wishlist
     */
    public function setProdPrice($prodPrice)
    {
        $this->prodPrice = $prodPrice;

        return $this;
    }

    /**
     * Get prodPrice
     *
     * @return float
     */
    public function getProdPrice()
    {
        return $this->prodPrice;
    }
}
