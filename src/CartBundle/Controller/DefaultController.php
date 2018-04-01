<?php

namespace CartBundle\Controller;

use CartBundle\Entity\Wishlist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Stripe\Stripe as Stripe;
class DefaultController extends Controller
{

    /**
     * @Route("/cart",name="cart_default_index")
     */
    public function indexAction(Request $request)
    {
        if ($this->getUser() != null) {

            $session = $request->getSession();
            if (!($session->has("cart"))) {

                $session->set("cart", array());
                $user = $this->getUser();
                $email = $user->getEmail();
                $em = $this->getDoctrine()->getManager();
                $total = $em->getRepository("CartBundle:Wishlist")->totalUser($this->getUser());
                $wishlist = $em->getRepository("CartBundle:Wishlist")->findBy(["emailClient" => $email]);
                if (is_array(is_array($wishlist))) {
                    return $this->render('CartBundle::cart.html.twig', ["carts" => $wishlist, "array" => "yes", "total" => $total]);
                } else if (is_array($wishlist)) {
                    return $this->render('CartBundle::cart.html.twig', ["carts" => null, "array" => "no", "total" => $total]);

                }
                return $this->render('CartBundle::cart.html.twig', ["carts" => $wishlist, "array" => "null", "total" => null]);
            } else {

                $user = $this->getUser();
                $email = $user->getEmail();
                $em = $this->getDoctrine()->getManager();
                $total = $em->getRepository("CartBundle:Wishlist")->totalUser($this->getUser());
                $wishlist = $em->getRepository("CartBundle:Wishlist")->findBy(["emailClient" => $this->getUser()->getEmail()]);

                if ($this->contains_array($wishlist)) {

                    return $this->render('CartBundle::cart.html.twig', ["carts" => $wishlist, "array" => "yes", "total" => $total]);
                } else if ($wishlist!=null && !$this->contains_array($wishlist)) {

                    return $this->render('CartBundle::cart.html.twig', ["carts" => $wishlist, "array" => "no", "total" => $total]);

                }
            }
        } else {
            $wishlist=null;
            $session = $request->getSession();

            if (!($session->has("cart")) && $session->get("cart")==null) {
                $session->set("cart", array());
            } else if ($session->get("cart") != null) {
                $wishlist = $session->get("cart");

                $total = $this->totalAction($request);
                if ($this->contains_array($wishlist)) {

                    return $this->render('CartBundle::cart.html.twig', ["carts" => $wishlist, "array" => "yes", "total" => $total]);
                } else if ($wishlist!=null && !$this->contains_array($wishlist) ) {
                    return $this->render('CartBundle::cart.html.twig', ["carts" => $wishlist, "array" => "no", "total" => $total]);

                }

            }
            }

             return $this->render('CartBundle::cart.html.twig', ["carts" => $wishlist, "array" => "null", "total" => null]);

    }
 /**
  * @param Request
  *
  * @author Mohamed Abdelhafidh
  */
    public function totalAction(Request $request)
    {
        $total=0;
        $session = $request->getSession();
        if($session->get("cart")!=null)
        {
            $carts=$session->get("cart");
            if($this->contains_array($carts)){
            foreach ($carts as $cart)
            {
                if(array_key_exists("price",$cart))
                $total+=$cart["price"];
            }
            }
            else if ($carts!= null && $carts instanceof Wishlist)
            {
                $total=$carts->getProdPrice();
            }
            else if(is_array($carts) && array_key_exists("price",$carts))
            {
                $total=$carts["price"];

            }


        }
        else
        {
          $session->set("cart",null);
            $total=0;
        }

        return $total;
    }



    /**
     * @Route("/cart/{slug}",name="add_to_cart")
     * @author Mohamed Abdelhafidh
     */

    public function addToCartAction($slug,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $product = $em->getRepository("ProductBundle:Product")->find($slug);
        $wishliste = new Wishlist();
        $wishliste->setProdName($product->getName());
        $wishliste->setDescription($product->getDescription());
        $wishliste->setProdPrice($product->getPrice());
        $wishliste->setId($product->getId());
        if($this->getUser()!=null)
        {
            $wishliste->setEmailClient($this->getUser()->getEmail());
            $em->persist($wishliste);
            $em->flush();
        }
        else
        {
            $session = $request->getSession();
            if ($session->has("cart") && $session->get("cart")!=null)
            {
                $cart =$session->get("cart");
                array_push($cart,["name"=>$wishliste->getProdName(),"desc"=>$wishliste->getDescription(),"price"=>$wishliste->getProdPrice(),"id"=>$wishliste->getId()]);
                $session->set("cart",$cart);
            }
            else
            {
                $session->set("cart",array());
                $cart =$session->get("cart");
                array_push($cart,["name"=>$wishliste->getProdName(),"desc"=>$wishliste->getDescription(),"price"=>$wishliste->getProdPrice(),"id"=>$wishliste->getId()]);
                $session->set("cart",$cart);

            }
        }
        return new Response("Cart updated successfuly");
    }

    /**
     * @Route("/cart/delete/{slug}",name="delete_from_cart")
     */
        public function deleteAction(Request $request,$slug)
        {
            if($this->getUser()!=null)
            {
                $em=$this->getDoctrine()->getManager();
                $cart=$em->getRepository("CartBundle:Wishlist")->find($slug);
                $em->remove($cart);
                $em->flush();
                $total = $em->getRepository("CartBundle:Wishlist")->totalUser($this->getUser());

                return new Response($total);
            }
            else
            {
                $session = $request->getSession();
                $carts = $session->get("cart");

                    foreach ($carts as $key => $cart)
                    {
                        if(!empty($cart))
                        {
                            if($cart["id"]==$slug)
                            {
                               // return new Response("found");
                                unset($carts[$key]);
                                $session->set("cart",$carts);
                                break;
                            }

                        }
                        else
                        {
                            continue;
                        }

                    }
                $total = $this->totalAction($request);
                return new Response($total);

            }

        }

    /**
     * @Route("/checkout/stripe",name="stripe_checkout")
     */
public function stripeCheckoutAction(Request $request)
{
    Stripe::setApiKey("pk_test_p5iZQvuYEQg218WFtClGMw43");
    $charge =$request->request->get("stripeToken");
    return new Response(var_dump($charge));
}



    /**
     * @param $array
     * @return bool
     * @author Mohamed Abdelhafidh
     */
    function contains_array($array){
        foreach($array as $value){
            if(is_array($value)) {
                return true;
            }
        }
        return false;
    }

}
