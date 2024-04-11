<?php

namespace App\Command;
use App\Entity\Commentaire;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Comment;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:createComment',
    description: 'Ajoute un commentaire à un article',
)]

class CreateCommentCommand extends Command
{
    private ArticleRepository $articleRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, ArticleRepository $articleRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
    }

    protected function configure(): void
    {
        $this->addArgument('nb_commentaires', InputArgument::REQUIRED, 'Nombre de commentaires');
        $this->addArgument('id_article', InputArgument::REQUIRED, 'id de l\'article');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $idArticle = $input->getArgument('id_article');
        $article = $this -> articleRepository ->find($idArticle);
        
        if (!$article) {
            $io->error('impossible de trouver l\'article'.$idArticle);
            return Command::FAILURE;
        }

        $nbCommentaires = $input->getArgument('nb_commentaires');

        for ($compteur = 0; $compteur < $nbCommentaires; $compteur++){
            $io -> comment('Création de commentaire'.$compteur);
            $commentaire = new Commentaire();
            $commentaire -> setTexte("Description de l'article".$compteur);
            $commentaire -> setAuteur('Matthieu');
            $commentaire -> setDate(new \DateTime());
            $commentaire -> setArticle($article);
            $this->entityManager -> persist($commentaire);
        }

        $this -> entityManager -> flush(); 
        $io -> success($compteur.' commentaires créés !');

        return Command::SUCCESS;
    }
}

