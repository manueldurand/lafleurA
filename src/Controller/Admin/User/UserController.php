<?php

namespace App\Controller\Admin\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/users', name: 'app_admin_users_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(): Response
    {
        return $this->render('admin/users/list.html.twig', []);
    }

    #[Route('/new', name: 'new')]
    public function new(): Response
    {
        return $this->render('admin/users/list.html.twig', []);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(): Response
    {
        return $this->render('admin/users/list.html.twig', []);
    }
}
