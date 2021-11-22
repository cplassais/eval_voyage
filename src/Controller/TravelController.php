<?php

namespace App\Controller;

use App\Entity\Travel;
use App\Form\TravelType;
use App\Repository\TravelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function PHPUnit\Framework\isEmpty;

/**
 * @Route("/travel")
 */
class TravelController extends AbstractController
{
    /**
     * @Route("/", name="travel_index", methods={"GET"})
     */
    public function index(TravelRepository $travelRepository): Response
    {
        return $this->render('travel/index.html.twig', [
            'travel' => $travelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="travel_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $travel = new Travel();
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);
        $errors = $validator->validate($travel);
        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile1 = $form->get('image1')->getData();
            if ($imgFile1) {
                $originalFilename = pathinfo($imgFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile1->guessExtension();
                try {
                    $imgFile1->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $travel->setImage1($newFilename);
            }
            $imgFile2 = $form->get('image2')->getData();
            if ($imgFile2) {
                $originalFilename = pathinfo($imgFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile2->guessExtension();
                try {
                    $imgFile2->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $travel->setImage2($newFilename);
            }
            $imgFile3 = $form->get('image3')->getData();
            if ($imgFile3) {
                $originalFilename = pathinfo($imgFile3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile3->guessExtension();
                try {
                    $imgFile3->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $travel->setImage3($newFilename);
            }
            $pdfFile = $form->get('pdf')->getData();
            if ($pdfFile) {
                $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pdfFile->guessExtension();
                try {
                    $pdfFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $travel->setPdf($newFilename);
            }

            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                return $this->render('error/error.html.twig', ['error' => $errorsString]);
            } else {
                $entityManager->persist($travel);
                $entityManager->flush();
                return $this->redirectToRoute('travel_index');
            }

            return $this->redirectToRoute('travel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('travel/new.html.twig', [
            'travel' => $travel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="travel_show", methods={"GET"})
     */
    public
    function show(Travel $travel): Response
    {
        return $this->render('travel/show.html.twig', [
            'travel' => $travel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="travel_edit", methods={"GET", "POST"})
     */
    public
    function edit(Request $request, Travel $travel, ValidatorInterface $validator, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        if (!$travel) {
            return $this->render('error/error.html.twig', ['error' => 'Le voyage n\'existe pas']);
        }
        $imgOri1 = $travel->getImage1();
        $imgOri2 = $travel->getImage2();
        $imgOri3 = $travel->getImage3();
        $pdfOri = $travel->getPdf();
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);
        $errors = $validator->validate($travel);

        if ($form->isSubmitted()) {

            $imgFile1 = $form->get('image1')->getData();
            if ($imgFile1) {
                $originalFilename = pathinfo($imgFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile1->guessExtension();
                try {
                    $imgFile1->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                if (isset($imgOri1)) {
                    unlink('../public/images/upload/' . $imgOri1);
                }
                $travel->setImage1($newFilename);
            } else {
                $travel->setImage1($imgOri1);
            }

            $imgFile2 = $form->get('image2')->getData();
            if ($imgFile2) {
                $originalFilename = pathinfo($imgFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile2->guessExtension();
                try {
                    $imgFile2->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                if (isset($imgOri2)) {
                    unlink('../public/images/upload/' . $imgOri2);
                }
                $travel->setImage2($newFilename);
            } else {
                $travel->setImage2($imgOri2);
            }

            $imgFile3 = $form->get('image3')->getData();
            if ($imgFile3) {
                $originalFilename = pathinfo($imgFile3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile3->guessExtension();
                try {
                    $imgFile3->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                if (isset($imgOri3)) {
                    unlink('../public/images/upload/' . $imgOri3);
                }
                $travel->setImage3($newFilename);
            } else {
                $travel->setImage3($imgOri3);
            }

            $pdfFile = $form->get('pdf')->getData();
            if ($pdfFile) {
                $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pdfFile->guessExtension();
                try {
                    $pdfFile->move(
                        $this->getParameter('pdf_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                if (isset($pdfOri)) {
                    unlink('../public/pdf/upload/' . $pdfOri);
                }
                $travel->setPdf($newFilename);
            } else {
                $travel->setPdf($pdfOri);
            }
            if (count($errors) > 0) {
                $errorsString = (string)$errors;
//                return $this->render('error/error.html.twig', ['error' => $errorsString]);
                return $this->renderForm('travel/edit.html.twig', [
                    'travel' => $travel,
                    'form' => $form,
                    'error' => $errorsString
                ]);
            } else {
                $entityManager->persist($travel);
                $entityManager->flush();
                return $this->redirectToRoute('travel_index');
            }
        }
        return $this->renderForm('travel/edit.html.twig', [
            'travel' => $travel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="travel_delete", methods={"POST"})
     */
    public
    function delete(Request $request, Travel $travel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $travel->getId(), $request->request->get('_token'))) {
            $imgOri1 = $travel->getImage1();
            $imgOri2 = $travel->getImage2();
            $imgOri3 = $travel->getImage3();
            $pdfOri = $travel->getPdf();

            if (isset($pdfOri)) {
                unlink('../public/pdf/upload/' . $pdfOri);
            }
            if (isset($imgOri1)) {
                unlink('../public/images/upload/' . $imgOri1);
            }
            if (isset($imgOri2)) {
                unlink('../public/images/upload/' . $imgOri2);
            }
            if (isset($imgOri3)) {
                unlink('../public/images/upload/' . $imgOri3);
            }
            $entityManager->remove($travel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('travel_index', [], Response::HTTP_SEE_OTHER);
    }
}
