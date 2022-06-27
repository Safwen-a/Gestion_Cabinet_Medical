<?php

namespace App\Controller;

use App\Entity\DossierMedical;
use App\Form\DossierMedicalType;
use App\Repository\DossierMedicalRepository;
use App\Repository\PatientRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dossier/medical')]
class DossierMedicalController extends AbstractController
{
    #[Route('/', name: 'app_dossier_medical_index', methods: ['GET'])]
    public function index(DossierMedicalRepository $dossierMedicalRepository): Response
    {
        return $this->render('dossier_medical/index.html.twig', [
            'dossier_medicals' => $dossierMedicalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dossier_medical_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DossierMedicalRepository $dossierMedicalRepository): Response
    {
        $dossierMedical = new DossierMedical();
        $form = $this->createForm(DossierMedicalType::class, $dossierMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossierMedicalRepository->add($dossierMedical, true);

            return $this->redirectToRoute('app_dossier_medical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dossier_medical/new.html.twig', [
            'dossier_medical' => $dossierMedical,
            'form' => $form,
        ]);
    }
    #[Route('/show', name: 'app_mon_dossier_medical_show', methods: ['GET'])]
    public function mon_show(DossierMedicalRepository $dossierMedicalRepository,PatientRepository $patientRepository): Response
    {
        $patient=$patientRepository->findOneByEmail($this->getUser()->getUserEmail());
        if($dossierMedicalRepository->findOneByPatientId($patient->getId())) {
            $dossierMedical = $dossierMedicalRepository->findOneByPatientId($patient->getId());
            return $this->render('dossier_medical/show.html.twig', [
                'dossier_medical' => $dossierMedical,
            ]);
        }
        else {
            return $this->render('users/index.html.twig');
        }
    }
    #[Route('/{id}', name: 'app_dossier_medical_show', methods: ['GET'])]
    public function show(DossierMedical $dossierMedical, DossierMedicalRepository $dossierMedicalRepository): Response
    {


        return $this->render('dossier_medical/show.html.twig', [
            'dossier_medical' => $dossierMedical,
        ]);

    }



    #[Route('/{id}/edit', name: 'app_dossier_medical_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DossierMedical $dossierMedical, DossierMedicalRepository $dossierMedicalRepository): Response
    {
        $form = $this->createForm(DossierMedicalType::class, $dossierMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossierMedicalRepository->add($dossierMedical, true);

            return $this->redirectToRoute('app_dossier_medical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dossier_medical/edit.html.twig', [
            'dossier_medical' => $dossierMedical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dossier_medical_delete', methods: ['POST'])]
    public function delete(Request $request, DossierMedical $dossierMedical, DossierMedicalRepository $dossierMedicalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dossierMedical->getId(), $request->request->get('_token'))) {
            $dossierMedicalRepository->remove($dossierMedical, true);
        }

        return $this->redirectToRoute('app_dossier_medical_index', [], Response::HTTP_SEE_OTHER);
    }
}
