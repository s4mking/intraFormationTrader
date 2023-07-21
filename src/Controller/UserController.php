<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('user/testSammmmmm.html.twig', [
            'last_username' => 'samuel',
        ]);
    }

    #[Route('/', name: 'app_default')]
    public function indexGeneral(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/profile', name: 'user_profile')]
    public function profile(): Response
    {
        return $this->render('user/testSammmmmm.html.twig', [
            'last_username' => 'samuel',
        ]);
    }
}

