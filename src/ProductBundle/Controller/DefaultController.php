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
        return $this->render('ProductBundle::weeding.html.twig');
    }
}
