<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticleRepository;



class StripeController extends AbstractController
{
    #[Route('/pay', name: 'pay')]
    public function index()
    {
        Stripe::setApiKey($_ENV['STRIPE_SECRET']);
        $produits[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => intval($_SESSION['total']) * 100,
                'product_data' => [
                    'name' => 'Produit test',
                ],
            ],
            'quantity' => 5,
        ];
        $checkout_session = Session::create([
            'customer_email' => 'cmoueza@castelis.com',
            'payment_method_types' => ['card', 'sepa_debit'],
            'line_items' => [$produits],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('app_payment_failed', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return $this->redirect($checkout_session->url);
    }
    // #[Route('/amount', name: 'amount')]
    // public function amount(SessionInterface $session, ArticleRepository $articleRepository): 
    // {
    //     $total=0 ;
    //     $panier= $session ("panier", []);
    //     if(!$panier){   
    //         return new ("Erreur, aucun panier", ::HTTP_BAD_REQUEST);
    //     }
    //     foreach($panier as $id => $quantite){
    //         $prix= $articleRepository->find($id)->getPrix();
    //         $sousTotal = $prix * $quantite;
    //         $total += $sousTotal;
    //     }
    //     return new ($total, HTTP_ACCEPTED);
    // }
    #[Route('/success', name: 'app_payment_success')]
    public function success()
    {
        return $this->render('stripe/success.html.twig', []);
    }

    #[Route('/failed', name: 'app_payment_failed')]
    public function failed()
    {
        return $this->render('stripe/failed.html.twig', []);
    }
}
