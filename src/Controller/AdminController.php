<?php 
// src/Controller/AdminController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/api/admin', name: 'admin_dashboard')]
  
    public function dashboard(): JsonResponse
    {
        // return $this->render('admin/dashboard.html.twig');
        return new JsonResponse(['message' => 'Welcome to admin dashboard'], JsonResponse::HTTP_OK);
    }
}


?>