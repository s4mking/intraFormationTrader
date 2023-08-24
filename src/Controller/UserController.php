<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\AccountType;
use App\Form\AccountTypeFormType;
use App\Form\ContactFormType;
use App\Form\EditProfileFormType;
use App\Form\OperationFormType;
use App\Form\OperationUserFormType;
use App\Helper\OperationHelper;
use App\Repository\OperationRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class UserController extends AbstractController{

    public function __construct(
        private EntityManagerInterface $entityManager,
        public OperationHelper $operationHelper,
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

    /**
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    #[Route('/profile/editpassword', name: 'edit_password')]
    public function editPassword(Request $request, UserPasswordHasherInterface $passwordHasher): Response
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

        return $this->render('user/editpassword.html.twig', [
            'accountForm' => $form->createView(),
            'user' => $user
        ]);

    }

    #[Route('/profile/edit', name: 'edit_profile')]
    public function editProfile(Request $request): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(EditProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setAdresse($form->getData()->getAdresse());
            $user->setNom($form->getData()->getNom());
            $user->setPrenom($form->getData()->getPrenom());
            $user->setTelephone($form->getData()->getTelephone());
            $this->entityManager->persist($user);
            $this->entityManager->flush();


            $this->addFlash('success', 'Votre compte a été modifié.');
            return $this->redirectToRoute('app_default');
            }
        return $this->render('user/editprofile.html.twig', [
            'profileForm' => $form->createView(),
            'user' => $user
        ]);

    }

    #[Route('/profile', name: 'get_profile')]
    public function getProfile(): Response
    {

        $user = $this->getUser();

        return $this->render('user/view.html.twig', [
            'user' => $user
        ]);

    }

    #[Route('/requesttransaction', name: 'app_request_transaction')]
    public function addCredit(Request $request, SluggerInterface $slugger, OperationRepository $operationRepository): Response
    {
        $form = $this->createForm(OperationUserFormType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $retrait = $form->get('retrait')->getData();
            $credit = $form->get('credit')->getData();
            $this->operationHelper->addCredit($retrait,$user);
            $this->operationHelper->addRetrait($credit,$user);
            $this->addFlash('success', 'Votre demande a été pris en compte');
            }
        $operations = $operationRepository->findOperationsPendingForUser($user);
        return $this->render('operation/request_transaction.html.twig', [
            'form' => $form,
            'operations' => $operations
        ]);
    }

    #[Route('/help', name: 'app_help')]
    public function helpController(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $subject = 'Demande de contact sur votre site de ' . $contactFormData['email'];
            $content = $contactFormData['nom'] . ' vous a envoyé le message suivant: ' . $contactFormData['message'];
            $email = (new Email())
            ->text($content)
            ->subject($subject)
            ->sender($contactFormData['email'])
                ->to('intranetformation@gmail.com')
            ;
            $mailer->send($email);
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('app_default');
        }
        return $this->render('user/contact.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }

}

