<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;

class PublicController extends AbstractController
{
    //1 ArticleRepositoryà ajouter avec autowiring
    //2 créer une route accueil( qui retourne les articles)
    //3 qui va charger les articles
    //4 on passe les articles à la vue twig 
    //5 modifier la vue twig pour rendre les articles visibles

    //6 créer une autre route article qui va afficher un article avec ses commentaires
    //7 charger un article avec ses comm grâce à articleREpository 
    //8 passer les infos à la vue twig 
    //9 modifier la vue twig
    
    // créer  un lien dans la vue twig accueil, pour aller sur la route article 
    private ArticleRepository $articleRepository;
    
    public function __construct(ArticleRepository $articleRepository){
        $this->articleRepository = $articleRepository;
    }
    
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        $articles =$this->articleRepository->findAll();
        return $this->render('public/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'app_article')]
    public function article(int $id): Response
    {
        $article =$this->articleRepository->find($id);
        $commentaires = $article ->getCommentaire();
        return $this->render('public/article.html.twig', [
            'articles' => $article,
            'commentaires' => $commentaires,
        ]);
    }
    
}
