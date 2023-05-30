<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article1 = [
            "nom" => "bla",
            "prix" => "25",
            "description" => "blablablabla",
        ];
        $article2 = [
            "nom" => "bla2",
            "prix" => "44",
            "description" => "blablablabla2",
        ];
        $article3 = [
            "nom" => "bla",
            "prix" => "84",
            "description" => "blablablabla",
        ];
        $article4 = [
            "nom" => "bla2",
            "prix" => "54",
            "description" => "blablablabla2",
        ];
        $articles =[0=>$article1, 1=>$article2, 2=>$article3, 3=>$article4];

        // $articles = [[
        //     "nom" => "souris",
        //     "prix" => "79",
        //     "description" => "Razer Deathadder 2013",
        // ],
        // [
        //     "nom" => "clavier",
        //     "prix" => "59",
        //     "description" => "Razer Blackwidow 2013",
        // ]];
        foreach($articles as $cle => $article){
            
                $newArticle = new Article();
                $newArticle->setNom($article["nom"]);
                $newArticle->setPrix($article["prix"]);
                $newArticle->setDescription($article["description"]);
                
                $manager->persist($newArticle);
                
            };
        
            
        
        
        $article = new Article();
        $article->setNom("Tasse Hunik");
        $article->setPrix(10);
        $article->setDescription("Une superbe tasse aux couleurs vives représentant Hunik group");
        $manager->persist($article);

        $article = new Article();
        $article->setNom("Stickers Hunik");
        $article->setPrix(2);
        $article->setDescription("Une plaquette de stickers personnalisés");
        $manager->persist($article);

        $article = new Article();
        $article->setNom("Notebook Hunik");
        $article->setPrix(5);
        $article->setDescription("Un Notebook classe, estampillé Hunik et fourni avec un stylo");
        $manager->persist($article);

        $article = new Article();
        $article->setNom("Ecran");
        $article->setPrix(500);
        $article->setDescription("Un Notebook classe, estampillé Hunik et fourni avec un stylo");
        $manager->persist($article);

        $manager->flush();
    }
}
