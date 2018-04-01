<?php

namespace ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/weeding")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("ProductBundle:Product")->findAll();
        if(!empty($products))
        {
            return $this->render("ProductBundle::weeding.html.twig",array("products"=>$products));
        }
        return $this->render('ProductBundle::weeding.html.twig',array("products"=>null));
    }
}
