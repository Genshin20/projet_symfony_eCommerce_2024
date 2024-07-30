<?php

namespace App\Controller\Backend;

use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/model', name: 'admin.model')]
class ModelController extends AbstractController
{
    //je persiste en base de donnée EntityManagerInterface $em
    public function __construct(
        private EntityManagerInterface $em

    ) {
    }
    #[Route('/', name: '.index', methods:['GET'])]
    public function index(ModelRepository $repo): Response
    {
        return $this->render('Backend/Models/index.html.twig', [
            'models' => $repo->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods:['POST','GET'])]
    public function create(Request $request):Response {

        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->em->persist($model);
            $this->em->flush();
            //on cree un message de redirection
            $this->addFlash('success', 'le model  a été bien crée');
            //on redirige
            return $this->redirectToRoute('admin.model.index');

        }

        return $this->render('Backend/Models/create.html.twig', [
        'form' => $form,
        ]);

    }

    #[Route('/{id}/update', name:'.update', methods:['POST','GET'])]
    public function update(?model $model, Request $request):Response {
        if(!$model) {
            $this->addFlash('error', 'le model demandée n\'existe pas');
            return $this->redirectToRoute('admin.model.index');
            
        }
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($model);
            $this->em->flush();

            $this->addFlash('success', ' Le model a bien été modifié');
            return $this->redirectToRoute('admin.model.index');
        }
        return $this->render('Backend/Models/update.html.twig', [
            'form' => $form
        ]);

    }
    #[Route('/{id}/delete', name:'.delete', methods:['POST'])]

    public function delete(){
        
    }

}
