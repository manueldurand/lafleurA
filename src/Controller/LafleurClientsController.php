<?php

namespace App\Controller;

use App\Entity\LafleurClients;
use App\Form\LafleurClientsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lafleur/admin/clients')]
class LafleurClientsController extends AbstractController
{
    #[Route('/', name: 'app_admin_lafleur_clients_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $lafleurClients = $entityManager
            ->getRepository(LafleurClients::class)
            ->findAll();

        return $this->render('admin/lafleur_clients/index.html.twig', [
            'lafleur_clients' => $lafleurClients,
        ]);
    }

    #[Route('/new', name: 'app_admin_lafleur_clients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lafleurClient = new LafleurClients();
        $form = $this->createForm(LafleurClientsType::class, $lafleurClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lafleurClient);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_lafleur_clients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lafleur_clients/new.html.twig', [
            'lafleur_client' => $lafleurClient,
            'form' => $form,
        ]);
    }

    #[Route('/{idClient}', name: 'app_admin_lafleur_clients_show', methods: ['GET'])]
    public function show(LafleurClients $lafleurClient): Response
    {
        return $this->render('admin/lafleur_clients/show.html.twig', [
            'lafleur_client' => $lafleurClient,
        ]);
    }

    #[Route('/{idClient}/edit', name: 'app_admin_lafleur_clients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LafleurClients $lafleurClient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LafleurClientsType::class, $lafleurClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_lafleur_clients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lafleur_clients/edit.html.twig', [
            'lafleur_client' => $lafleurClient,
            'form' => $form,
        ]);
    }

    #[Route('/{idClient}', name: 'app_admin_lafleur_clients_delete', methods: ['POST'])]
    public function delete(Request $request, LafleurClients $lafleurClient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lafleurClient->getIdClient(), $request->request->get('_token'))) {
            $entityManager->remove($lafleurClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_lafleur_clients_index', [], Response::HTTP_SEE_OTHER);
    }
}
