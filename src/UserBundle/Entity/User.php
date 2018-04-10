<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=100, nullable=true)
     */
    private $role;


    /**
     * @var string
     *
     * @ORM\Column(name="fname", type="string", length=100, nullable=true)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="lname", type="string", length=100, nullable=true)
     */
    private $lname;





    /**
     * @var integer
     *
     * @ORM\Column(name="phoneNumber", type="integer", nullable=true)
     */
    private $phonenumber;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=50, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=150, nullable=true)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=200, nullable=true)
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_SU", type="date", nullable=true)
     */
    private $dateSu;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_like", type="integer", nullable=true)
     */
    private $nbrLike;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=50, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=50, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="membership", type="string", length=50, nullable=true)
     */
    private $membership;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=true)
     */
    private $etat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateD", type="date", nullable=true)
     */
    private $dated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDD", type="date", nullable=true)
     */
    private $datedd;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }



    /**
     * Set fname
     *
     * @param string $fname
     *
     * @return User
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname
     *
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }
    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set lname
     *
     * @param string $lname
     *
     * @return User
     */
    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Get lname
     *
     * @return string
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set phonenumber
     *
     * @param integer $phonenumber
     *
     * @return User
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return integer
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return User
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
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
     * Set dateSu
     *
     * @param \DateTime $dateSu
     *
     * @return User
     */
    public function setDateSu($dateSu)
    {
        $this->dateSu = $dateSu;

        return $this;
    }

    /**
     * Get dateSu
     *
     * @return \DateTime
     */
    public function getDateSu()
    {
        return $this->dateSu;
    }

    /**
     * Set nbrLike
     *
     * @param integer $nbrLike
     *
     * @return User
     */
    public function setNbrLike($nbrLike)
    {
        $this->nbrLike = $nbrLike;

        return $this;
    }

    /**
     * Get nbrLike
     *
     * @return integer
     */
    public function getNbrLike()
    {
        return $this->nbrLike;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
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
     * @return User
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
     * Set zip
     *
     * @param string $zip
     *
     * @return User
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
     * Set membership
     *
     * @param string $membership
     *
     * @return User
     */
    public function setMembership($membership)
    {
        $this->membership = $membership;

        return $this;
    }

    /**
     * Get membership
     *
     * @return string
     */
    public function getMembership()
    {
        return $this->membership;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return User
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set dated
     *
     * @param \DateTime $dated
     *
     * @return User
     */
    public function setDated($dated)
    {
        $this->dated = $dated;

        return $this;
    }

    /**
     * Get dated
     *
     * @return \DateTime
     */
    public function getDated()
    {
        return $this->dated;
    }

    /**
     * Set datedd
     *
     * @param \DateTime $datedd
     *
     * @return User
     */
    public function setDatedd($datedd)
    {
        $this->datedd = $datedd;

        return $this;
    }

    /**
     * Get datedd
     *
     * @return \DateTime
     */
    public function getDatedd()
    {
        return $this->datedd;
    }
}
