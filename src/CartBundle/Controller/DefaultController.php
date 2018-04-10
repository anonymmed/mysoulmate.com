<?php

namespace CartBundle\Controller;

use CartBundle\Entity\Wishlist;
use JMS\Payment\CoreBundle\Tests\Functional\TestBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Stripe\Stripe as Stripe;
use \Stripe\Charge as Charge;
use JMS\Payment\CoreBundle\PluginController\Result;

class DefaultController extends Controller
{

    /**
     * @Route("/cart",name="cart_default_index")
     */
    public function indexAction(Request $request)
    {
        if ($this->getUser() != null) {
            $em1 = $this->getDoctrine()->getManager();
            $checkVoucher = $em1->getRepository("CartBundle:Wishlist")->getVoucherNotNull($this->getUser());
            $session = $request->getSession();
            if (!($session->has("cart"))) {
                if($checkVoucher != null || $checkVoucher != "")
                $session->set("cart", array());
                $user = $this->getUser();
                $email = $user->getEmail();
                $em = $this->getDoctrine()->getManager();
                if($checkVoucher != null || $checkVoucher != "")
                {
                    $vprice = $this->getVoucherValue($checkVoucher);
                    $total = $em1->getRepository("CartBundle:Wishlist")->totalUser1($this->getUser(), $vprice);
                }
                else {
                    $total = $em->getRepository("CartBundle:Wishlist")->totalUser($this->getUser());
                }
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
                if($checkVoucher != null || $checkVoucher != "")
                {
                    $vprice = $this->getVoucherValue($checkVoucher);
                    $total = $em1->getRepository("CartBundle:Wishlist")->totalUser1($this->getUser(), $vprice);
                }
                else
                {
                $total = $em->getRepository("CartBundle:Wishlist")->totalUser($this->getUser());
                }
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
                array_push($cart,["name"=>$wishliste->getProdName(),"desc"=>$wishliste->getDescription(),"price"=>$wishliste->getProdPrice(),"id"=>$wishliste->getId(),"discount"=>0]);
                $session->set("cart",$cart);
            }
            else
            {
                $session->set("cart",array());
                $cart =$session->get("cart");
                array_push($cart,["name"=>$wishliste->getProdName(),"desc"=>$wishliste->getDescription(),"price"=>$wishliste->getProdPrice(),"id"=>$wishliste->getId(),"discount"=>0]);
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
        try{
            if($this->getUser()!=null) {
                Stripe::setApiKey("sk_test_pqwVr0qaXLRcMry0G9xsJWvN");
                $token = $request->request->get("stripeToken");
                $em = $this->getDoctrine()->getManager();
                $total = $em->getRepository("CartBundle:Wishlist")->totalUser($this->getUser());
                $total *= 42;
                $charge = Charge::create(array("amount" => $total, "currency" => "USD", "description" => "testing 123", "source" => $token));
                $em = $this->getDoctrine()->getManager();
                $wishlist = $em->getRepository("CartBundle:Wishlist")->findBy(array("emailClient" => $this->getUser()->getEmail()));
                if ($charge["status"] == "succeeded") {
                    foreach ($wishlist as $wishlista) {
                        $em->remove($wishlista);
                        $em->flush();

                    }
                      return $this->render("CartBundle::success.html.twig",["carts"=>null,"array"=>"no","total"=>0]);
                }
                else
                {
                    return $this->render("CartBundle::error.html.twig",["carts"=>null,"array"=>"no","total"=>0]);
                }
            }
            else
            {
                $session = $request->getSession();
                $cart = $session->get("cart");
                if($cart != null)
                {

                    $total = $this->totalAction($request);
                    Stripe::setApiKey("sk_test_pqwVr0qaXLRcMry0G9xsJWvN");
                    $token = $request->request->get("stripeToken");
                    $total*=42;

                    $charge = Charge::create(array("amount" =>$total, "currency" => "USD", "description" => "testing 123", "source" => $token));

                    if(array_key_exists("status",$charge) )
                    {
                        if($charge["status"]=="succeeded")
                        {
                            $session->set("cart",array());
                            return new  Response("Sucess");

                        }
                        else
                        {
                            return new Response("Failure");
                        }
                    }

                    return new Response(var_dump($charge["status"]));

                }
                else
                {
                    return new Response("cart is empty");
                }
            }
        } catch(\Stripe\Error\Card $e) {
            $body = $e->getJsonBody();
            $err = $body['error'];
            return new Response(var_dump($err));
        }
    }


    public function getVoucherValue($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $voucher = $em->getRepository("CartBundle:Voucher")->findOneBy(array("code"=>$slug));
        if(empty($voucher))
        {
            return null;
        }
        else
        {
            return intval($voucher->getDiscount());
        }

    }

    /**
     * @Route("/cart/discount/{slug}",name="cart_voucher")
     */
    public function discountAction(Request $request,$slug)
    {
        $em = $this->getDoctrine()->getManager();
        $vprice = $this->getVoucherValue($slug);
        if($vprice != null)
        {


        $em->getRepository("CartBundle:Wishlist")->changeTotal($this->getUser(),$slug);
        }
        $checkVoucher = $em->getRepository("CartBundle:Wishlist")->findOneBy(array("emailClient"=>$this->getUser()->getEmail()));
        if($checkVoucher != null)
            $checkVoucher=$checkVoucher->getVoucher();
        if($checkVoucher!=null || $checkVoucher != "")
        {
            $voucher = $em->getRepository("CartBundle:Voucher")->findOneBy(array("code"=>$slug));
            if(empty($voucher))
            {
                return new Response("no voucher found");
            }
            else {
                $vprice = $this->getVoucherValue($slug);
                if($vprice==null)
                {
                    $total = $em->getRepository("CartBundle:Wishlist")->totalUser($this->getUser());
                }
                else
                {
                $em->getRepository("CartBundle:Wishlist")->changeTotal($this->getUser(),$slug);
                $total = $em->getRepository("CartBundle:Wishlist")->totalUser1($this->getUser(), $vprice);
                }
                return new Response($total);
            }
        }
        else
        {
        $voucher = $em->getRepository("CartBundle:Voucher")->findOneBy(array("code"=>$slug));
        if(empty($voucher))
        {
            return new Response("no voucher found");
        }
        else {
            $discount = intval($voucher->getDiscount());
            if ($this->getUser() != null) {
                $total = $em->getRepository("CartBundle:Wishlist")->totalUser($this->getUser())+4;

                $total -=($discount*$total)/100;
                return new Response($total);
            }
            else
            {
                $total = ($this->totalAction($request))+4;
                $total-=($discount*$total)/100;
                return new Response($total);
            }
        }
    }
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

    /**
     * @Route("/checkTotal",name="base_total_cart")
     */
    public function baseTotalAction(Request $request)
    {
        if($this->getUser() != null)
        {
            $em =$this->getDoctrine()->getManager();
            $total = $em->getRepository("CartBundle:Wishlist")->totalUser($this->getUser());
            return new Response($total);
        }
        else
        {
            return new Response($this->totalAction($request));

        }
    }

    /**
     * @Route("/checkLogged",name="check_logged")
     */
public function checkLoggedAction(Request $request)
{
    if($this->getUser()!=null)
    {
        return new Response("true");
    }
    return new Response("false");
}
    /**
     * @Route("/testb",name="redirect_b")
     */
    public function redirectbAction()
    {
        return $this->forward("ProductBundle:Default:index");
    }





}


