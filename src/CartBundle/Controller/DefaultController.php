<?php

namespace CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/cart")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $email=$user->getEmail();
    $em=$this->getDoctrine()->getManager();
    $wishlist=$em->getRepository("CartBundle:Wishlist")->findBy(["emailClient"=>$email]);
    if(is_array(is_array($wishlist)))
    {
        return $this->render('CartBundle::cart.html.twig',["carts"=>$wishlist,"array"=>"yes"]);
    }
    else if ($wishlist== null)
    {
        return $this->render('CartBundle::cart.html.twig',["carts"=>null,"array"=>"no"]);

    }
        return $this->render('CartBundle::cart.html.twig',["carts"=>$wishlist,"array"=>"no"]);
    }
}
