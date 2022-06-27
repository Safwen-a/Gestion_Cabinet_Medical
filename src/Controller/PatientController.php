<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/patient')]
class PatientController extends AbstractController
{
    #[Route('/', name: 'app_patient_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response
    {
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PatientRepository $patientRepository, UserRepository $userRepository): Response
    {
        $patient = new Patient();
        
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setUsername($patient->getFname().$patient->getLname());
            $user->setEmail($patient->getEmail());
            $user->setPassword(password_hash($patient->getFname()."123.",PASSWORD_DEFAULT));
            $user->setRoles(["ROLE_PATIENT"]);

            $userRepository->add($user, true);
            $patientRepository->add($patient, true);
            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, PatientRepository $patientRepository,UserRepository $userRepository): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $email=$patient->getEmail();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user=$userRepository->findOneBy(array('email' => $email));
            $user->setEmail($patient->getEmail());
            $userRepository->add($user, true);
            $patientRepository->add($patient, true);
            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, PatientRepository $patientRepository,UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $user=$userRepository->findOneByEmail($patient->getEmail());
            $userRepository->remove($user,true);
            $patientRepository->remove($patient, true);
        }

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }
}
