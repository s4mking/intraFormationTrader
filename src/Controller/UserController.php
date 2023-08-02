<?php

namespace App\Controller;

use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
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
    public function indexGeneral(OperationRepository $operationRepository, Request $request): Response
    {
        $user = $this->getUser();
/*        $operations = $operationRepository->findBy(['transmitter' => $user],['closeTime' => 'DESC']);*/

        $page = $request->query->get('page') ? $request->query->get('page') : 1;
        $operations = $operationRepository->findOperationsForUser($user, $page);
        $totalPosts = $operations->count();
        $limit = 25;
        $maxPages = ceil($totalPosts / $limit);
        $thisPage = $page;

        $totalLastWeek = $operationRepository->findTotalLastWeek($user);
        $totalLastLast = $operationRepository->findTotalLastLastWeek($user);
        $sumOperations = $operationRepository->countOperations($user);
        $totalSell = $operationRepository->findTotalSell($user);
        $totalBuy = $operationRepository->findTotalBuy($user);
        return $this->render('home/index.html.twig',
            [
                'operations' => $operations,
                'user' => $user,
                'weeklySum' => round($totalLastWeek['weekly_total'], 2),
                'lastWeeklySum' => round($totalLastLast['weekly_total'], 2),
                'sumOperations' => $sumOperations,
                'totalSell' => $totalSell['weekly_total'],
                'totalBuy' => $totalBuy['weekly_total'],
                'maxPages' => $maxPages,
                'thisPage' => $thisPage
            ]);
    }

    #[Route('/profile', name: 'user_profile')]
    public function profile(): Response
    {
        return $this->render('user/testSammmmmm.html.twig', [
            'last_username' => 'samuel',
        ]);
    }
}

