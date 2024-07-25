<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/users', name: 'admin.users')]
class UserController extends AbstractController{

    public function __construct(private EntityManagerInterface $em

    ){

    }
    // methode GET car on ne soumet pas de formulaire o
    #[Route('/', name:'.index', methods:'GET')]
    public function index(UserRepository $repo): Response
    {
        return $this->render('Backend/User/index.html.twig', [
            //recupere tous les les utilisateurs de la base de donnee on utilise findAll du repository
            'users' => $repo->findAll(),
        ]);
    }    
    #[Route('/{id}/update', name: '.update', methods:['GET', 'POST'])]
    public function update(?User $user, Request $request): Response{

     if(!$user){
         $this->addFlash('error', 'Utilisateur introuvable');
         return $this->redirectToRoute('admin.users.index');
    }
                   // Create and handle the form for updating the user
        $form = $this->createForm(UserType::class, $user, ['isAdmin' => true]);
        $form->handleRequest($request);

                    // Check if the form is submitted and valid
         if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur mis à jour avec succès');

            return $this->redirectToRoute('admin.users.index');

        }
                

  }
    
}
