<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Recruteur;
use App\Form\ConsultantCandidatType;
use App\Form\ConsultantRecruteurType;
use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConsultantController extends AbstractController
{
 /**
     * Espace consultants
     *
     * @param RecruteurRepository $repository
     * @return Response
     */
    #[Route('/consultant', 'index.consultant', methods : ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/consultant/index.html.twig');
    }
 
    /**
     * liste des recruteur inscris
     *
     * @param RecruteurRepository $repository
     * @return Response
     */
    #[Route('/consultant/recruteur', name: 'consultant.recruteur',methods:['GET'])]
    public function recruteur(RecruteurRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
        $recruteurs = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('pages/consultant/recruteur/index.html.twig', [
            'recruteurs' =>  $recruteurs ,
        ]);
    }

    #[Route('consultant/recruteur/edit/{id}','consultant.recruteur.edit', methods:['GET','POST'])]
    public function edit(Recruteur $recruteur, Request $request,EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(ConsultantRecruteurType::class,$recruteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $recruteur =$form->getData();
            $manager->persist($recruteur);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre ingrédient à été modifier avec succes !'
             );
             return $this->redirectToRoute('consultant.recruteur');
             
        }

        return $this->render('pages/consultant/recruteur/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/consultant/recruteur/delete/{id}','consultant.recruteur.delete', methods :['GET'])]
    public function delete(EntityManagerInterface $manager,Recruteur $recruteur):Response
    {
       $manager->remove($recruteur);
       $manager->flush();
       $this->addFlash(
           'success',
           'Votre ingrédient à été supprimer avec succes !'
        );
        return $this->redirectToRoute('consultant.recruteur');
    }

    #[Route('/consultant/candidat', name: 'consultant.candidat', methods : ['GET'])]
    public function candidat(CandidatRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
        $candidat = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/consultant/candidat/index.html.twig', [
            'candidats' => $candidat,
        ]);
    }

    #[Route('candidat/candidat/edit/{id}','consultant.candidat.edit', methods:['GET','POST'])]
    public function editCandidat(Candidat $candidat, Request $request,EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(ConsultantCandidatType::class,$candidat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $candidat =$form->getData();
            $manager->persist($candidat);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre ingrédient à été modifier avec succes !'
             );
             return $this->redirectToRoute('consultant.candidat');
             
        }

        return $this->render('pages/consultant/candidat/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/consultant/candidat/delete/{id}','consultant.candidat.delete', methods :['GET'])]
    public function deleteCandidat(EntityManagerInterface $manager,Candidat $candidat):Response
    {
       $manager->remove($candidat);
       $manager->flush();
       $this->addFlash(
           'success',
           'Votre ingrédient à été supprimer avec succes !'
        );
        return $this->redirectToRoute('consultant.candidat');
    }
}
