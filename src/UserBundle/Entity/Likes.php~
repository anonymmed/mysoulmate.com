<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likes
 *
 * @ORM\Table(name="likes")
 * @ORM\Entity
 */
class Likes
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
     * @ORM\Column(name="liked", type="string", length=50, nullable=false)
     */
    private $liked;

    /**
     * @var string
     *
     * @ORM\Column(name="liked_by", type="string", length=50, nullable=false)
     */
    private $likedBy;



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
     * Set liked
     *
     * @param string $liked
     *
     * @return Likes
     */
    public function setLiked($liked)
    {
        $this->liked = $liked;

        return $this;
    }

    /**
     * Get liked
     *
     * @return string
     */
    public function getLiked()
    {
        return $this->liked;
    }

    /**
     * Set likedBy
     *
     * @param string $likedBy
     *
     * @return Likes
     */
    public function setLikedBy($likedBy)
    {
        $this->likedBy = $likedBy;

        return $this;
    }

    /**
     * Get likedBy
     *
     * @return string
     */
    public function getLikedBy()
    {
        return $this->likedBy;
    }
}
