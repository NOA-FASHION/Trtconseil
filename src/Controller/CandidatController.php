<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidatController extends AbstractController
{
    #[Route('/candidat', name: 'index.candidat', methods : ['GET'])]
    public function index(CandidatRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
        $candidat = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/candidat/index.html.twig', [
            'candidats' => $candidat,
        ]);
    }

    #[Route('candidat/new','candidat.new',methods:['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $manager):Response
    {
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);
        if($form->isSubmitted()  && $form->isValid()){
            $candidat = $form->getData();
            $candidat->setActivation(false);
            $manager->persist($candidat);
            $manager->flush();
            $this->addFlash(
                'success',
                'le recruteur à été créer avec succes !'
             );
            return $this->redirectToRoute('index.candidat');
        }

        return $this->render('pages/candidat/new.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('candidat/edit/{id}','candidat.edit', methods:['GET','POST'])]
    public function edit(Candidat $candidat, Request $request,EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $candidat =$form->getData();
            $manager->persist($candidat);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre ingrédient à été modifier avec succes !'
             );
             return $this->redirectToRoute('index.candidat');
             
        }

        return $this->render('pages/candidat/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('candidat/annonce/','candidat.annonce', methods:['GET','POST'])]
    public function annonce(AnnonceRepository $repository,PaginatorInterface $paginator,Request $request):Response
    {

        $annonces = $paginator->paginate(
            $repository->findBy(["active"=>true]), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('pages/candidat/annonces.html.twig',[
            'annonces'=>$annonces,
            
        ]);
    }

}
