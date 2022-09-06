<?php

namespace App\Controller;

use App\Entity\Recruteur;
use App\Form\RecruteurType;
use App\Repository\RecruteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecruteurController extends AbstractController
{
    #[Route('/recruteur', name: 'recruteur.index')]
    public function index(RecruteurRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
        $recruteurs = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('pages/recruteur/index.html.twig', [
            'recruteurs' =>  $recruteurs ,
        ]);
    }

    #[Route('recruteur/new','recruteur.new',methods:['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $manager):Response
    {
        $recruteur = new Recruteur();
        $form = $this->createForm(RecruteurType::class,$recruteur);
        $form->handleRequest($request);
        if($form->isSubmitted()  && $form->isValid()){
            $recruteur = $form->getData();
            $recruteur->setActive(false);
            $manager->persist($recruteur);
            $manager->flush();
            $this->addFlash(
                'success',
                'le recruteur à été créer avec succes !'
             );
            return $this->redirectToRoute('recruteur.index');
        }

        return $this->render('pages/recruteur/new.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('recruteur/edit/{id}','recruteur.edit', methods:['GET','POST'])]
    public function edit(Recruteur $recruteur, Request $request,EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(RecruteurType::class,$recruteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $recruteur =$form->getData();
            $manager->persist($recruteur);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre ingrédient à été modifier avec succes !'
             );
             return $this->redirectToRoute('recruteur.index');
             
        }

        return $this->render('pages/recruteur/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
