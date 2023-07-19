<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\CSVFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

class OperationController extends AbstractController{
    #[Route('/importcsv', name: 'app_import_csv')]
    public function importCSV(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CSVFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $importedFile = $form->get('file')->getData();
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            $reader->setDelimiter(';');
            $spreadsheet = $reader->load($form->get('file')->getData());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            foreach ($rows as $row){
                $operation = new Operation(
                    $row[0],
                    $row[1],
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5],
                    $row[6],
                    $row[7],
                    $row[8],
                    $row[9],
                    $user
                );
                $entityManager->persist($operation);
            }

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($importedFile) {
                $originalFilename = pathinfo($importedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.csv';

                // Move the file to the directory where brochures are stored
                try {
                    $importedFile->move(
                        $this->getParameter('import_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
            }

            // ... persist the $product variable or any other work
        }
        $entityManager->flush();
        return $this->render('operation/new.html.twig', [
            'form' => $form,
        ]);
    }
}

