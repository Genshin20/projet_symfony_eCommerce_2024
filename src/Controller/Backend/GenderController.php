<?php

namespace App\Controller\Backend;

use App\Entity\Gender;
use App\Form\GenderType;
use App\Repository\GenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/genders', name: 'admin.genders')]
class GenderController extends AbstractController
{
   

    //je persiste en base de donnée EntityManagerInterface $em
    public function __construct( 
        Private EntityManagerInterface $em
    ){

    }
    #[Route('/', name: '.index', methods:['GET'])]
    public function index(GenderRepository $repo): Response
    {
        return $this->render('Backend/Genders/index.html.twig', [
            'genders' => $repo->findAll() ,
        ]);
    }
    #[Route('/create', name:'create', methods:['GET','POST'])]

    public function create(Request $request):Response{

        //creer nouvelle genre
        $gender = new Gender();
        //On cree notre formulaire
        $form = $this->createForm(GenderType::class, $gender);
        //recupereraion des donner avec le 
        $form->handleRequest($request);
        //si le formulaire est soumis et valid
        if($form->isSubmitted() && $form->isValid()){
        //on met en attend lobjet a persister
        $this->em->persist($gender);
        //on execute l'attente
        $this->em->flush();
        //on cree un message
        $this->addFlash('success', 'le genre a été bien crée');
        //on redirige
        return $this->redirectToRoute('admin/genders/index');

        }
        return $this->render('Backend/Genders/create.html.twig', [
            'form' => $form,
        ]);


    }
}
