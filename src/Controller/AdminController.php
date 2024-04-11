<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            //https://symfony.com/doc/current/forms.html#installation
            //https://stackoverflow.com/questions/31319773/twig-if-is-grantedrole-manager-check-is-not-granted

        ]);
    }
}
