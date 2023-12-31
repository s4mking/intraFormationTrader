<?php

namespace App\Controller;

use App\Entity\CustomStyle;
use App\Form\CustomStyleFormType;
use App\Model\OperationFromCSVDTO;
use App\Entity\Operation;
use App\Form\OperationFormType;
use App\Form\OperationType;
use App\Repository\CustomStyleRepository;
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
    public function importCSV(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager, CustomStyleRepository $customStyleRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $lastCustom = $customStyleRepository->findOneBy([], ['id' => 'desc']);
        if($lastCustom){
            $form = $this->createForm(CustomStyleFormType::class, $lastCustom);
        }else{
            $form = $this->createForm(CustomStyleFormType::class);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customStyle = new CustomStyle();
            $emailAdmin = $form->get('emailAdmin')->getData();
            if($emailAdmin){
                $customStyle->setEmailAdmin($emailAdmin);
                $entityManager->persist($customStyle);
                $entityManager->flush();
            }
            $importedFile = $form->get('Logo')->getData();
            if ($importedFile) {
                $originalFilename = pathinfo($importedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $backgroundImageName = 'logo.png';

                // Move the file to the directory where brochures are stored
                try {
                    $importedFile->move(
                        $this->getParameter('import_logo'),
                        $backgroundImageName
                    );
                    $this->addFlash('success', 'Votre logo a été modifié veuillez raffraichir le site.');
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $customStyle->setBackgroundImage($backgroundImageName);
            }
                $importedLogo = $form->get('LogoConnection')->getData();
            if ($importedLogo) {
                // Move the file to the directory where brochures are stored
                try {
                    $importedLogo->move(
                        $this->getParameter('import_logo'),
                        'imageville.jpeg'
                    );
                    $this->addFlash('success', 'Votre image de login a été modifié veuillez raffraichir le site.');
                } catch (FileException $e) {
                }
            }
            $importedFavicon = $form->get('Favicon')->getData();
            if ($importedFavicon) {
                // Move the file to the directory where brochures are stored
                try {
                    $importedFavicon->move(
                        $this->getParameter('import_logo'),
                        'favicon.ico'
                    );
                    $this->addFlash('success', 'Votre favicon a été modifié veuillez raffraichir le site.');
                } catch (FileException $e) {
                    dump($e);
                }
            }

            $this->addFlash('success', 'Vos modifications ont été prises en compte');
            return $this->redirectToRoute('app_default');

        }

        return $this->render('customstyles/new.html.twig', [
            'form' => $form,
        ]);
    }

}
