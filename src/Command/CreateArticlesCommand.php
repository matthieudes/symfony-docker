<?php

namespace App\Command;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:createArticles',
    description: 'Add a short description for your command',
)]
class CreateArticlesCommand extends Command
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('nb_articles', InputArgument::REQUIRED, 'Nombre d\'articles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nbArticles = $input ->getArgument('nb_articles');
        $io -> warning('Création de '.$nbArticles.' articles');
        if($nbArticles < 1) return Command::FAILURE;
        
        for ($compteur = 0; $compteur < $nbArticles; $compteur++){
            $io -> comment('Création d\'articles'.$compteur);
            $article = new Article();
            $article -> setTitle("Article numéro".$compteur);
            $article -> setDescription("Description de l'article".$compteur);
            $article -> setAuteur('Matthieu');
            $article -> setDate(new \DateTime());
            $this->entityManager -> persist($article);
        }

        $this -> entityManager -> flush(); 
        $io -> success($compteur.' articles créés !');

        return Command::SUCCESS;
    }
}
