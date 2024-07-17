<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/admin/users', name: 'admin.users')]
    public function index(): Response
    {
        return $this->render('backend/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
