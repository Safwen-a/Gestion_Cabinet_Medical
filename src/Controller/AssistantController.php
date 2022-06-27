<?php

namespace App\Controller;

use App\Entity\Assistant;
use App\Form\AssistantType;
use App\Repository\AssistantRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/assistant')]
class AssistantController extends AbstractController
{
    #[Route('/', name: 'app_assistant_index', methods: ['GET'])]
    public function index(AssistantRepository $assistantRepository): Response
    {
        return $this->render('assistant/index.html.twig', [
            'assistants' => $assistantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assistant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AssistantRepository $assistantRepository, UserRepository $userRepository): Response
    {
        $assistant = new Assistant();
        $form = $this->createForm(AssistantType::class, $assistant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setUsername($assistant->getFname() . $assistant->getLname());
            $user->setEmail($assistant->getEmail());
            $user->setPassword(password_hash($assistant->getFname() . "123.", PASSWORD_DEFAULT));
            $user->setRoles(["ROLE_ASSISTANT"]);
            $userRepository->add($user, true);

            $assistantRepository->add($assistant, true);

            return $this->redirectToRoute('app_assistant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('assistant/new.html.twig', [
            'assistant' => $assistant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assistant_show', methods: ['GET'])]
    public function show(Assistant $assistant): Response
    {
        return $this->render('assistant/show.html.twig', [
            'assistant' => $assistant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assistant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assistant $assistant, AssistantRepository $assistantRepository, UserRepository $userRepository): Response
    {
        $form = $this->createForm(AssistantType::class, $assistant);
        $email = $assistant->getEmail();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(array('email' => $email));
            $user->setEmail($assistant->getEmail());
            $userRepository->add($user, true);
            $assistantRepository->add($assistant, true);

            return $this->redirectToRoute('app_assistant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('assistant/edit.html.twig', [
            'assistant' => $assistant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assistant_delete', methods: ['POST'])]
    public function delete(Request $request, Assistant $assistant, AssistantRepository $assistantRepository, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $assistant->getId(), $request->request->get('_token'))) {
            $user = $userRepository->findOneByEmail($assistant->getEmail());
            $userRepository->remove($user, true);
            $assistantRepository->remove($assistant, true);
        }

        return $this->redirectToRoute('app_assistant_index', [], Response::HTTP_SEE_OTHER);
    }
}
