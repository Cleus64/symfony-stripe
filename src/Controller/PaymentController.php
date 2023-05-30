<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Stripe;

class PaymentController extends AbstractController
{

    #[Route('/order/create-session-stripe', name:'payment_stripe')]
    public function stripeCheckout()
    {
        \Stripe\Stripe::setApiKey("sk_test_51MI79lE2JqttEzXo9Mz9ztToABHWLQYyZVEaD23sZRpIsDCZn6FTiklPHaShd1Q1xgSe72HLi57mdIWBH1dOuShv001YoBTWRj");
        header('Content-Type: application/json');

    $YOUR_DOMAIN = 'http://localhost:4242';

    $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [[
    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
            'price' => 'price_1N3FjjE2JqttEzXozmqGyaVO',
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success.html',
        'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

    }
}