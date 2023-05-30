<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
session_start();

class CartController extends AbstractController
{
    /**
     * @requires mixed
     *
     */
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, ArticleRepository $articleRepository)
    {
        $panier = $session->get("panier", []);

        if (!is_array($panier)) {
            $session->set("panier", []);
        }

        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $article = $articleRepository->find($id);
            if ($article) {
                $dataPanier[] = [
                    "article" => $article,
                    "quantite" => $quantite
                ];
                $total += $article->getPrix() * $quantite;
            }
        }
        
        $_SESSION['total']=$total;
        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }

    #[Route('/{action}/{id}', name: 'panier')]
    public function add($id, $action, SessionInterface $session, ArticleRepository $articleRepository)
    {

        $panier = $session->get("panier", []);
        if (!is_array($panier)) {
            $session->set("panier", []);
        }
        if (!$articleRepository->find($id)) {
            return $this->redirectToRoute('app_cart');
        }

        switch ($action) {
            case 'add':
                if (!empty($panier[$id])){
                    $panier[$id]++;
                } else {
                    $panier[$id] = 1;
                }
                break;

            case 'minus':
                if (!empty($panier[$id])){

                    if ($panier[$id] > 1) {
                        $panier[$id]--;
                    } else {
                        unset($panier[$id]);
                    }
                }
                break;

            case 'remove':
                if (!empty($panier[$id])){

                    unset($panier[$id]);
                }
                break;

            default:
                return $this->redirectToRoute('app_cart');
                break;
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute('app_cart');
    }
}
