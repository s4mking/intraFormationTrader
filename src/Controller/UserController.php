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
        return $this->render('user/new.html.twig', [
            'last_username' => 'samuel',
        ]);
    }
}

