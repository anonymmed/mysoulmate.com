<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matching
 *
 * @ORM\Table(name="matching")
 * @ORM\Entity
 */
class Matching
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
     * @ORM\Column(name="user1", type="string", length=255, nullable=false)
     */
    private $user1;

    /**
     * @var string
     *
     * @ORM\Column(name="user2", type="string", length=255, nullable=false)
     */
    private $user2;



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
     * Set user1
     *
     * @param string $user1
     *
     * @return Matching
     */
    public function setUser1($user1)
    {
        $this->user1 = $user1;

        return $this;
    }

    /**
     * Get user1
     *
     * @return string
     */
    public function getUser1()
    {
        return $this->user1;
    }

    /**
     * Set user2
     *
     * @param string $user2
     *
     * @return Matching
     */
    public function setUser2($user2)
    {
        $this->user2 = $user2;

        return $this;
    }

    /**
     * Get user2
     *
     * @return string
     */
    public function getUser2()
    {
        return $this->user2;
    }
}
