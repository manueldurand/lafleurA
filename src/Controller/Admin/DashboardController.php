<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lafleur/admin', name: 'app_admin_')]
class DashboardController extends AbstractController
{
    #[Route('/lafleur/', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', []);
    }
}
