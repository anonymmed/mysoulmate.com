<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 25/03/2018
 * Time: 06:12
 */

namespace UserBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository
{

    public function findByRole($roles)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from("UserBundle:User", 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'.$roles.'"%');

        return $qb->getQuery()->getResult();
    }
}