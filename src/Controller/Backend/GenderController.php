<?php

namespace App\Controller\Backend;

use App\Entity\Gender;
use App\Form\GenderType;
use App\Repository\GenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/genders', name: 'admin.genders')]
class GenderController extends AbstractController
{


    //je persiste en base de donnée EntityManagerInterface $em
    public function __construct(
        private EntityManagerInterface $em

    ) {
    }
    #[Route('/', name: '.index', methods: ['GET'])]
    public function index(GenderRepository $repo): Response
    {
        return $this->render('Backend/Genders/index.html.twig', [
            'genders' => $repo->findAll(),
        ]);
    }
    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]

    public function create(Request $request): Response
    {

        //creer nouvelle genre
        $gender = new Gender();
        //On cree notre formulaire
        $form = $this->createForm(GenderType::class, $gender);
        //recupereraion des donner avec le 
        $form->handleRequest($request);
        //si le formulaire est soumis et valid
        if ($form->isSubmitted() && $form->isValid()) {
            //on met en attend lobjet a persister
            $this->em->persist($gender);
            //on execute l'attente
            $this->em->flush();
            //on cree un message
            $this->addFlash('success', 'le genre a été bien crée');
            //on redirige
            return $this->redirectToRoute('admin.genders.index');
        }
        return $this->render('Backend/Genders/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    public function update(?Gender $gender, Request $request): Response
    {
        if (!$gender) {

            $this->addFlash('error', 'Le genre demandée n\'existe pas');
            return $this->redirectToRoute('admin.genders.index');
        }
        $form = $this->createForm(GenderType::class, $gender);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($gender);
            $this->em->flush();

            $this->addFlash('success', ' Le gender a bien été modifié');
            return $this->redirectToRoute('admin.genders.index');
        }
        return $this->render('Backend/Genders/update.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]

  
    public function delete(?Gender $gender, request $request):RedirectResponse{
        if(!$request){
            $this->addFlash('error', 'Le genre demandée n\existe pas');

            return $this->redirectToRoute('admin.genders.index');

        }
      
        // pour verifier si un token est valide
        if($this->isCsrfTokenValid('delete'. $gender->getId(), $request->request->get('token'))){
            // le remove met en attente la suppression
           $this->em->remove($gender);
           
           $this->em->flush();
        
            $this->addFlash('success', 'Le genre a bien été suprimée');
        }else{
            $this->addFlash('error', 'Le jeton csrf est valide');
            
        }
        return $this->redirectToRoute('admin.genders.index');


    }
    

    }

