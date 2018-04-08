<?php

namespace SoulmateBundle\Controller;
use SoulmateBundle\Entity\Likes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/mysoulmate")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("UserBundle:User")->findAll();
        return $this->render("SoulmateBundle::soulmates.html.twig",["users"=>$users]);

    }

    /**
     * @Route("/mysoulmate/checkMatch/{slug}",name="checkMatch")
     */
        public function checkMatchAcction(Request $request,$slug)
        {
            $em = $this->getDoctrine()->getManager();
            $mylikes = $em->getRepository("SoulmateBundle:Likes")->findBy(["likedBy"=>$this->getUser()->getEmail()]);
            $likes = $em->getRepository("SoulmateBundle:Likes")->findBy(["liked"=>$this->getUser()->getEmail()]);
            $result = $em->getRepository("SoulmateBundle:Likes")->getMyMatch($slug,$this->getUser());
            if(count($result)<2)
            return new Response("false");
            else
                return new Response("true");


        }

    /**
     * @Route("/mysoulmate/checkMatch",name="checkGlobalMatch")
     */
    public function checkGlobalMatchAction()
    {
        if($this->getUser() != null)
        {
        $count =0;
        $em = $this->getDoctrine()->getManager();
        $matching = $em->getRepository("SoulmateBundle:Matching")->findBy(array("user1"=>$this->getUser()->getEmail()));
        $matching2 = $em->getRepository("SoulmateBundle:Matching")->findBy(array("user2"=>$this->getUser()->getEmail()));
       $count+=count($matching);
       $count+=count($matching2);
        return new Response($count);
        }
        else
            return new Response(0);
    }

    /**
     * @Route("/mysoulmate/likeUser/{slug}",name="likeUser")
     */
    public function likeUserAction(Request $request,$slug)
    {
        $em = $this->getDoctrine()->getManager();

        $soulmate = new Likes();
        $soulmate->setLikedBy($this->getUser()->getEmail());
        $soulmate->setLiked($slug);
        $em->persist($soulmate);
        $em->flush();
        return new Response("success");

    }

}