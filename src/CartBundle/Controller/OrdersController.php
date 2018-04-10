<?php
namespace CartBundle\Controller;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\PluginController\Exception\InvalidPaymentInstructionException;
use JMS\Payment\CoreBundle\PluginController\Result;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CartBundle\Entity\Order;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/orders")
 */
class OrdersController extends Controller
{

    /**
     * @Route("/new/{amount}")
     */
    public function newAction($amount)
    {
        $em = $this->getDoctrine()->getManager();

        $order = new Order($amount);
        $em->persist($order);
        $em->flush();

        return $this->redirect($this->generateUrl('cart_orders_show', [
            'id' => $order->getId(),
        ]));
    }
    /**
     * @Route("/{id}/show")
     * @Template
     */
    public function showAction(Request $request, Order $order)
    {
        $form = $this->createForm(ChoosePaymentMethodType::class, null, [
            'amount'   => $order->getAmount(),
            'currency' => 'EUR',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ppc = $this->get('payment.plugin_controller');
            try {
                $ppc->createPaymentInstruction($instruction = $form->getData());
            } catch (InvalidPaymentInstructionException $e) {
            }

            $order->setPaymentInstruction($instruction);

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush($order);

            return $this->redirect($this->generateUrl('cart_orders_paymentcreate', [
                'id' => $order->getId(),
            ]));
        }

        return [
            'order' => $order,
            'form'  => $form->createView(),
        ];
    }
    private function createPayment(Order $order)
    {
        $instruction = $order->getPaymentInstruction();
        $pendingTransaction = $instruction->getPendingTransaction();

        if ($pendingTransaction !== null) {
            return $pendingTransaction->getPayment();
        }

        $ppc = $this->get('payment.plugin_controller');
        $amount = $instruction->getAmount() - $instruction->getDepositedAmount();

        return $ppc->createPayment($instruction->getId(), $amount);
    }
    /**
     * @Route("/{id}/payment/create")
     */
    public function paymentCreateAction($order)
    {
        $payment = $this->createPayment($order);

        $ppc = $this->get('payment.plugin_controller');
        $result = $ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());

        if ($result->getStatus() === Result::STATUS_SUCCESS) {
            return $this->redirect($this->generateUrl('cart_orders_paymentcomplete', [
                'id' => $order->getId(),
            ]));
        }

        if ($result->getStatus() === Result::STATUS_PENDING) {
            $ex = $result->getPluginException();

            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();

                if ($action instanceof VisitUrl) {
                    return $this->redirect($action->getUrl());
                }
            }
        }

        throw $result->getPluginException();

        // In a real-world application you wouldn't throw the exception. You would,
        // for example, redirect to the showAction with a flash message informing
        // the user that the payment was not successful.
    }
    /**
     * @Route("/{id}/payment/complete")
     */
    public function paymentCompleteAction(Order $order)
    {
        return new Response('Payment complete');
    }


}