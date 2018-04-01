<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 25/03/2018
 * Time: 06:12
 */

namespace CartBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use UserBundle\Entity\User;

class CartRepository extends EntityRepository
{

    public function totalUser(User $user)

    {
        $query=$this->getEntityManager()->createQuery("select sum(t.prodPrice) from CartBundle:Wishlist t WHERE t.emailClient = :email")->setParameter("email",$user->getEmail());

        try {
            $result =$query->getSingleScalarResult();

        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }
        return $result;
    }
}