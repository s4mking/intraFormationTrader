<?php

namespace App\Controller;

use App\Form\AccountType;
use App\Form\AccountTypeFormType;
use App\Form\OperationFormType;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class UserController extends AbstractController{

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }
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

    #[Route('/trading', name: 'app_user_trading')]
    public function userTrading(OperationRepository $operationRepository, Request $request): Response
    {
        $user = $this->getUser();
        /*        $operations = $operationRepository->findBy(['transmitter' => $user],['closeTime' => 'DESC']);*/

        $page = $request->query->get('page') ? $request->query->get('page') : 1;
        $operations = $operationRepository->findEveryOperationsForUser($user, $page);
        $totalPosts = $operations->count();
        $limit = 25;
        $maxPages = ceil($totalPosts / $limit);
        $thisPage = $page;

        $totalLastWeek = $operationRepository->findTotalLastWeek($user);
        $totalLastLast = $operationRepository->findTotalLastLastWeek($user);
        $sumOperations = $operationRepository->countOperations($user);
        $totalSell = $operationRepository->findTotalSell($user);
        $totalBuy = $operationRepository->findTotalBuy($user);
        return $this->render('user/user_trading.html.twig',
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

    #[Route('/monportefeuille', name: 'app_user_portefeuille')]
    public function userPortefeuille(OperationRepository $operationRepository, Request $request): Response
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
        return $this->render('user/portefeuille.html.twig',
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

    /**
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    #[Route('/profile/edit', name: 'edit_profile')]
    public function editProfile(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(AccountTypeFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();

            // Si l'ancien mot de passe est bon

            if ($passwordHasher->isPasswordValid($user, $oldPassword)) {
                $newPassword = $form->get('password')->getData();
                $newEncodedPassword = $passwordHasher->hashPassword($user, $newPassword);

                $user->setPassword($newEncodedPassword);
                $this->entityManager->persist($user);
                $this->entityManager->flush();



                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('app_default');
            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('user/edit.html.twig', [
            'accountForm' => $form->createView(),
        ]);

    }

}

