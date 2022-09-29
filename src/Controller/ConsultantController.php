<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Candidat;
use App\Entity\Recruteur;
use App\Repository\UserRepository;
use App\Form\ConsultantAnnonceType;
use App\Form\ConsultantCandidatType;
use App\Form\ConsultantRecruteurType;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatRepository;
use App\Repository\RecruteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    #[IsGranted('ROLE_CONSULTANT')]
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
    #[IsGranted('ROLE_CONSULTANT')]
    public function recruteur(UserRepository $repository1,RecruteurRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
        //  $userRcruteur=$repository->findAllRecruteurforUser();
        // dd($userRcruteur);
        // $users = $repository1->findAll();
        $recruteurs = $paginator->paginate(
            $repository->findAllRecruteurforUser(), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        // $recruteurUser = $repository->findRecruteursFromUser($users);
        // dd($recruteurUser);
        return $this->render('pages/consultant/recruteur/index.html.twig', [
            'recruteurs' =>  $recruteurs ,
            
        ]);
    }

    #[Route('consultant/recruteur/edit/{id}','consultant.recruteur.edit', methods:['GET','POST'])]
    #[IsGranted('ROLE_CONSULTANT')]
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
    #[IsGranted('ROLE_CONSULTANT')]
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
    #[IsGranted('ROLE_CONSULTANT')]
    public function candidat(CandidatRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
        

        // $userCandidat=$repository->findAllCandidatforUser();
       
        $candidat = $paginator->paginate(
            $repository->findAllCandidatforUser(), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/consultant/candidat/index.html.twig', [
            'candidats' => $candidat,
        ]);
    }

    #[Route('consultant/candidat/edit/{id}','consultant.candidat.edit', methods:['GET','POST'])]
    #[IsGranted('ROLE_CONSULTANT')]
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
    #[IsGranted('ROLE_CONSULTANT')]
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

    #[Route('consultant/annonce/','consultant.annonce', methods:['GET','POST'])]
    #[IsGranted('ROLE_CONSULTANT')]
    public function annonce(AnnonceRepository $repository,PaginatorInterface $paginator,Request $request):Response
    {

        $annonces = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('pages/consultant/annonces/index.html.twig',[
            'annonces'=>$annonces,
            
        ]);
    }

    #[Route('consultant/annonce/edit/{id}','consultant.annonce.edit', methods:['GET','POST'])]
    #[IsGranted('ROLE_CONSULTANT')]
    public function editAnnonces(Annonce $annonces, Request $request,EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(ConsultantAnnonceType::class,$annonces);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $annonces =$form->getData();
            $manager->persist($annonces);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre annonce à été modifier avec succes !'
             );
             return $this->redirectToRoute('consultant.annonce');
             
        }

        return $this->render('pages/consultant/annonces/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }


     /**
     * liste des recruteur inscris
     *
     * @param RecruteurRepository $repository
     * @return Response
     */
    #[Route('/consultant/candidature', name: 'consultant.candidature',methods:['GET'])]
    #[IsGranted('ROLE_CONSULTANT')]
    public function candidature(CandidatRepository $repository3,UserRepository $repository1,CandidatureRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
        
      
        $candidatures = $repository->findAll();

   
        $annonceCandidature = $repository3->findMessagesFromUser($candidatures);

        // $recruteurUser = $repository->findRecruteursFromUser($users);
        // dd($recruteurUser);
        return $this->render('pages/consultant/candidature/index.html.twig', [
            'candidats'=>$annonceCandidature
           
        ]);
    }
}
