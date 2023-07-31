<?php

namespace App\Controller;

use App\Entity\CustomStyle;
use App\Form\CustomStyleFormType;
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

#[Route('/customstyle')]
class CustomStyleController extends AbstractController
{

    #[Route('/importimages', name: 'app_import_images')]
    public function importCSV(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(CustomStyleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customStyle = new CustomStyle();

            $importedFile = $form->get('BackgroundImage')->getData();
            if ($importedFile) {
                $originalFilename = pathinfo($importedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $backgroundImageName = $safeFilename . '-' . uniqid() . '.jpg';

                // Move the file to the directory where brochures are stored
                try {
                    $importedFile->move(
                        $this->getParameter('import_directory'),
                        $backgroundImageName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $customStyle->setBackgroundImage($backgroundImageName);
            }
            $importedLogo = $form->get('LogoFile')->getData();
            if ($importedLogo) {
                $originalFilename = pathinfo($importedLogo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $logoImageName = $safeFilename . '-' . uniqid() . '.jpg';

                // Move the file to the directory where brochures are stored
                try {
                    $importedLogo->move(
                        $this->getParameter('import_directory'),
                        $logoImageName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $customStyle->setLogoFile($logoImageName);
            }

            $entityManager->persist($customStyle);
            $entityManager->flush();
        }

        return $this->render('customstyles/new.html.twig', [
            'form' => $form,
        ]);
    }

}
