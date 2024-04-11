<?php

namespace App\Command;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;


#[AsCommand(
    name: 'AddAdmin',
    description: 'Add an admin role to user',
)]
class AddAdminCommand extends Command
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    protected function configure(): void
    {
        $this->addArgument('id_user', InputArgument::REQUIRED, 'Id utilisateur')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id_user = $input->getArgument('id_user');
        $user = $this -> userRepository ->find($id_user);

        $roles = ['ROLE_ADMIN'];
        $user -> setRoles($roles);
        $this->entityManager -> persist($user);

        $this->entityManager -> flush();
        $io->success(' L\'utilisateur avec l\'id '.$id_user.' à acquis le rôle admin !');
        return Command::SUCCESS;
    }
}
