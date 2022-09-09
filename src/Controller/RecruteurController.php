<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Recruteur;
use App\Form\RecruteurType;
use App\Form\RecruteurAnnonceType;
use App\Repository\AnnonceRepository;
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


    #[Route('recruteur/annonce/{id}','recruteur.annonce', methods:['GET','POST'])]
    public function annonce(AnnonceRepository $repository,PaginatorInterface $paginator,Request $request,int $id):Response
    {
        $annonces  = $repository->findBy(["recruteur"=>$id]);
       
        return $this->render('pages/recruteur/annonce/index.html.twig',[
            'annonces'=>$annonces,
            'id'=>$id
        ]);
    }

    #[Route('/recruteur/annonce/new/{id}','recruteur.annonce.new',methods:['GET', 'POST'])]
    public function newAnnonce(RecruteurRepository $repository, Request $request, EntityManagerInterface $manager,int $id):Response
    {

        $recruteur =$repository->findOneBy(["id"=>$id]);
        // dd( $partenaires);
        $annonces = new annonce();
        $form = $this->createForm(RecruteurAnnonceType::class,$annonces);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $annonces = $form->getData();
            $annonces->setActive(false);
            $annonces ->setRecruteur($recruteur);
            $manager->persist( $annonces);
            $manager->flush();
            
            $this->addFlash(
               'success',
               'Votre annonce à été céer avec succes !'
            );
        //  return $this->redirectToRoute('structure.index');
      
        }
        
        return $this->render('pages/recruteur/annonce/new.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/recruteur/annonce/edit/{id}/{id1}','recruteur.annonce.edit',methods:['GET', 'POST'])]
    public function editAnnonce(RecruteurRepository $repository1,AnnonceRepository $repository, int $id, int $id1,Request $request,EntityManagerInterface $manager):Response
    {
        $recruteur =$repository1->findOneBy(["id"=>$id]);
        $annonces =$repository->findOneBy(["id"=>$id1]);
        $form = $this->createForm(RecruteurAnnonceType::class, $annonces);
        $form->handleRequest($request);
        
        if($form->isSubmitted()  && $form->isValid()){
            $annonces = $form->getData();
            $manager->persist($annonces);
            $manager->flush();
            // $this->addFlash(
            //     'success',
            //     'la structure à été modifier avec succes !'
            //  );
            // return $this->redirectToRoute('partenaire.index');
        }

        return $this->render('pages/recruteur/annonce/edit.html.twig',[
            'form' => $form->createView(),
            'recruteur' => $recruteur

        ]);
    }

    #[Route('/recruteur/annonce/suppression/{id}/{id1}','recruteur.annonce.delete', methods :['GET'])]
    public function delete(EntityManagerInterface $manager,Annonce $annonces,int $id, int $id1):Response
    {
        dd($annonces);
       $manager->remove($annonces);
       $manager->flush();
       $this->addFlash(
           'success',
           'Votre ingrédient à été supprimer avec succes !'
        );
        return $this->redirectToRoute('recruteur.annonce', ['id' =>$id ]);
    }

}
