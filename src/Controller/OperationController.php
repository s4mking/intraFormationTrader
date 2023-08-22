<?php

namespace App\Controller;

use App\Model\OperationFromCSVDTO;
use App\Entity\Operation;
use App\Form\OperationFormType;
use App\Form\OperationType;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CSVFormType;
use DateTime;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/operation')]
class OperationController extends AbstractController
{

    #[Route('/importcsv', name: 'app_import_csv')]
    public function importCSV(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(CSVFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $form->get('utilisateur')->getData();
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            $reader->setDelimiter(';');
            $spreadsheet = $reader->load($form->get('file')->getData());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            foreach ($users as $user){
                $sum=0;
                foreach ($rows as $row) {

                    if ($row[0] == 'Symbol' || is_null($row[8]) || is_null($row[0]) ) {
                        continue;
                    }
                    $operationDto = new OperationFromCSVDTO($row);
                    $operation = new Operation(
                        $operationDto->symbol,
                        $operationDto->position,
                        $operationDto->type,
                        $operationDto->lots,
                        $operationDto->openTime,
                        $operationDto->openPrice,
                        $operationDto->closeTime,
                        $operationDto->closePrice,
                        $operationDto->profit,
                        $operationDto->netProfit,
                        $user
                    );
                    $sum+=floatval($operationDto->profit);
                    $entityManager->persist($operation);
                }
                $actualBalance = $user->getAccountBalance();
                $user->setAccountBalance($actualBalance+ $sum);
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        return $this->render('operation/newcsv.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/addcredit', name: 'app_credit')]
    public function addCredit(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(OperationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $retrait = $form->get('retrait')->getData();
            $credit = $form->get('credit')->getData();
           /* $number = $form->get('number')->getData();*/
            $users = $form->get('utilisateur')->getData();
            foreach ($users as $user){
                $actualBalance = $user->getAccountBalance();
                if(isset($retrait)){
                    $now = new DateTime();
                    $operation = new Operation(
                        '',
                        0,
                        'Retrait',
                        0,
                        $now,
                        0,
                        $now,
                        0,
                        -$retrait,
                        0,
                        $user
                    );
                    $operation->setIsVerified(false);
                    $operation->setIsApproved(false);
                    $entityManager->persist($operation);
                    $user->setAccountBalance($actualBalance+ (-$retrait));
                }

                if(isset($credit)){
                    $now = new DateTime();
                    $operationCredit = new Operation(
                        '',
                        0,
                        'Credit',
                        0,
                        $now,
                        0,
                        $now,
                        0,
                        $credit,
                        0,
                        $user
                    );
                    $operationCredit->setIsVerified(true);
                    $operationCredit->setIsApproved(true);
                    $entityManager->persist($operationCredit);
                    $user->setAccountBalance($actualBalance+ $credit);
                }
                $entityManager->persist($user);
            }

            $entityManager->flush();
            }

        return $this->render('operation/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/approve', name: 'app_operation_approve', methods: ['GET','POST'])]
    public function approveOperation(Request $request, Operation $operation, EntityManagerInterface $entityManager): Response
    {
        $operation->setIsApproved(true);
        $operation->setIsVerified(true);
        $entityManager->persist($operation);
        $user = $operation->getTransmitter();
        $actualBalance = $user->getAccountBalance();
        $user->setAccountBalance($actualBalance+ $operation->getProfit());
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_operations_approval');
    }

    #[Route('/{id}/refus', name: 'app_operation_refus', methods: ['GET','POST'])]
    public function refusOperation(Request $request, Operation $operation, EntityManagerInterface $entityManager): Response
    {
        $operation->setIsApproved(false);
        $operation->setIsVerified(true);
        $entityManager->persist($operation);
        $entityManager->flush();
        return $this->redirectToRoute('app_operations_approval');
    }

    #[Route('/demandes', name: 'app_operations_approval')]
    public function approvesOperations(Request $request, OperationRepository $operationRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('operation/indexVerified.html.twig', [
            'operations' => $operationRepository->findBy(array('isVerified' => 0)),
        ]);
    }

    #[Route('/{id}', name: 'app_operation_show', methods: ['GET'])]
    public function show(Operation $operation): Response
    {
        return $this->render('operation/show.html.twig', [
            'operation' => $operation,
        ]);
    }

#[Route('/', name: 'app_operation_index', methods: ['GET'])]
    public function index(OperationRepository $operationRepository): Response
    {
        $user = $this->getUser();
        return $this->render('operation/index.html.twig', [
            'operations' => $operationRepository->findBy(array('transmitter' => $user)),
        ]);
    }

    #[Route('/new', name: 'app_operation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('app_operation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('operation/new.html.twig', [
            'operation' => $operation,
            'form' => $form,
        ]);
    }




    #[Route('/{id}/edit', name: 'app_operation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Operation $operation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_operation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('operation/edit.html.twig', [
            'operation' => $operation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_operation_delete', methods: ['POST'])]
    public function delete(Request $request, Operation $operation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($operation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_operation_index', [], Response::HTTP_SEE_OTHER);
    }

}
