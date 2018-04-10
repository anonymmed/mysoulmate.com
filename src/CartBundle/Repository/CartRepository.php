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
public function getVoucherNotNull(User $user)
{
    $result ="";
    $query=$this->getEntityManager()->createQuery("select t.voucher from CartBundle:Wishlist t WHERE t.voucher IS NOT NULL AND t.emailClient = :email")->setParameter("email",$user->getEmail());
        try {
            $result= $query->getResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {

        }
        if ($result != null)
    return $result[0]["voucher"];
else
    return null;
    }
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
    public function totalUser1(User $user,$price)

    {
        $query=$this->getEntityManager()->createQuery("select sum(t.prodPrice-(t.prodPrice*$price/100)) from CartBundle:Wishlist t WHERE t.emailClient = :email")->setParameter("email",$user->getEmail());

        try {
            $result =$query->getSingleScalarResult();

        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }
        return $result;
    }
    public function changeTotal(User $user,$voucher)

    {
        $query=$this->getEntityManager()->createQuery("update CartBundle:Wishlist t  set t.voucher=:voucher WHERE t.emailClient = :email")->setParameter("voucher",$voucher)->setParameter("email",$user->getEmail());


            $query->execute();

    }



}