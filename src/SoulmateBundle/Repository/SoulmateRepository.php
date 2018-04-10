<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 25/03/2018
 * Time: 06:12
 */

namespace SoulmateBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use SoulmateBundle\Entity\Likes;
use UserBundle\Entity\User;

class SoulmateRepository extends EntityRepository
{
public function getMyMatch($email,User $user)
{
    $result = null;
    $query=$this->getEntityManager()->createQuery("select l.liked,l.likedBy from SoulmateBundle:Likes l WHERE l.liked = :email and l.likedBy= :email1")->setParameter("email",$user->getEmail())->setParameter("email1",$email);

    try {
        $result =$query->getScalarResult();
        if($result == null || $result == "")
        {
            return null;
        }
        else
        {
            return $result[0];

        }

    } catch (NoResultException $e) {
    } catch (NonUniqueResultException $e) {
    }

}
}