<?php

namespace CartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stripe
 *
 * @ORM\Table(name="stripe")
 * @ORM\Entity(repositoryClass="CartBundle\Repository\StripeRepository")
 */
class Stripe
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cardNumber", type="string", length=18, nullable=true)
     */
    private $cardNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="cvv", type="string", length=4, nullable=true)
     */
    private $cvv;

    /**
     * @var string
     *
     * @ORM\Column(name="expMonth", type="string", length=2, nullable=true)
     */
    private $expMonth;

    /**
     * @var string
     *
     * @ORM\Column(name="expYear", type="string", length=4, nullable=true)
     */
    private $expYear;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=8, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="ammount", type="float", nullable=true)
     */
    private $ammount;

    /**
     * Stripe constructor.
     * @param string $cardNumber
     * @param string $cvv
     * @param string $expMonth
     * @param string $expYear
     * @param string $email
     * @param string $city
     * @param string $state
     * @param string $address
     * @param string $country
     * @param string $zip
     * @param float $ammount
     */
    public function __construct($cardNumber, $cvv, $expMonth, $expYear, $email, $city, $state, $address, $country, $zip, $ammount)
    {
        $this->cardNumber = $cardNumber;
        $this->cvv = $cvv;
        $this->expMonth = $expMonth;
        $this->expYear = $expYear;
        $this->email = $email;
        $this->city = $city;
        $this->state = $state;
        $this->address = $address;
        $this->country = $country;
        $this->zip = $zip;
        $this->ammount = $ammount;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cardNumber
     *
     * @param string $cardNumber
     *
     * @return Stripe
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set cvv
     *
     * @param string $cvv
     *
     * @return Stripe
     */
    public function setCvv($cvv)
    {
        $this->cvv = $cvv;

        return $this;
    }

    /**
     * Get cvv
     *
     * @return string
     */
    public function getCvv()
    {
        return $this->cvv;
    }

    /**
     * Set expMonth
     *
     * @param string $expMonth
     *
     * @return Stripe
     */
    public function setExpMonth($expMonth)
    {
        $this->expMonth = $expMonth;

        return $this;
    }

    /**
     * Get expMonth
     *
     * @return string
     */
    public function getExpMonth()
    {
        return $this->expMonth;
    }

    /**
     * Set expYear
     *
     * @param string $expYear
     *
     * @return Stripe
     */
    public function setExpYear($expYear)
    {
        $this->expYear = $expYear;

        return $this;
    }

    /**
     * Get expYear
     *
     * @return string
     */
    public function getExpYear()
    {
        return $this->expYear;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Stripe
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Stripe
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
     * Set state
     *
     * @param string $state
     *
     * @return Stripe
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Stripe
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
     * Set country
     *
     * @param string $country
     *
     * @return Stripe
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
     * Set zip
     *
     * @param string $zip
     *
     * @return Stripe
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Stripe
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
     * Set ammount
     *
     * @param float $ammount
     *
     * @return Stripe
     */
    public function setAmmount($ammount)
    {
        $this->ammount = $ammount;

        return $this;
    }

    /**
     * Get ammount
     *
     * @return float
     */
    public function getAmmount()
    {
        return $this->ammount;
    }
}
