<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/lafleur', name: 'app_home')]
    public function index(): Response
    {
        if($this->getUser()){
            return $this->redirectToRoute('app_admin_dashboard');
        }

        return $this->redirectToRoute('app_login');
    }
}
