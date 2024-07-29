<?php

namespace App\Controller\Backend;

use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/model', name: 'admin.model')]
class ModelController extends AbstractController
{
    #[Route('/', name: '.index', methods:['GET'])]
    public function index(ModelRepository $repo): Response
    {
        return $this->render('Backend/Models/index.html.twig', [
            'models' => $repo->findAll()
        ]);
    }
    
}
