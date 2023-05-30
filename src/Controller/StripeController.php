<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticleRepository;

class StripeController extends AbstractController
{
    #[Route('/pay', name: 'pay')]
    public function index(): Response
    {

        return $this->redirect($_ENV["PATH_ENV"] . '/checkout.html');
    }
    #[Route('/amount', name: 'amount')]
    public function amount(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        $total=0 ;
        $panier= $session ("panier", []);
        if(!$panier){   
            return new Response("Erreur, aucun panier", Response::HTTP_BAD_REQUEST);
        }
        foreach($panier as $id => $quantite){
            $prix= $articleRepository->find($id)->getPrix();
            $sousTotal = $prix * $quantite;
            $total += $sousTotal;
        }
        return new Response($total, Response::HTTP_ACCEPTED);
    }


}
