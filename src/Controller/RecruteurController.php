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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecruteurController extends AbstractController
{
    #[Route('/recruteur', name: 'recruteur.index')]
    #[IsGranted('ROLE_RECRUTEUR')]
    public function index(RecruteurRepository $repository,AnnonceRepository $repository1,PaginatorInterface $paginator,Request $request): Response
    {

          /**
        * @var User
         */
        $user=$this->getUser();
        if(!$user->isIsRecruteur()){
            return $this->redirectToRoute('home.index');
        }
      
        $recruteur = $repository->findOneBy(['userRecrutueur'=> $this->getUser()]);
        
        if($recruteur === null){
            return $this->redirectToRoute('recruteur.new');
        }
        $annonces  = $repository1->findBy(["recruteur"=>$recruteur->getId()]);
       
        return $this->render('pages/recruteur/index.html.twig', [
            'recruteur' =>  $recruteur ,
            'annonces'=>$annonces,
            'id'=>$recruteur->getId()
        ]);
    }

    #[Route('recruteur/new','recruteur.new',methods:['GET', 'POST'])]
    #[IsGranted('ROLE_RECRUTEUR')]
    public function new(Request $request,EntityManagerInterface $manager):Response
    {

          /**
        * @var User
         */
        $user=$this->getUser();
        // $idUser=$user->getId();
        $recruteur = new Recruteur();
        $form = $this->createForm(RecruteurType::class,$recruteur);
        $form->handleRequest($request);
        if($form->isSubmitted()  && $form->isValid()){
            $recruteur = $form->getData();
            $recruteur->setActive(false);
            $recruteur->setUserRecrutueur( $user);
            $manager->persist($recruteur);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre profil à été complété avec succes !'
             );
            return $this->redirectToRoute('recruteur.index');
        }

        return $this->render('pages/recruteur/new.html.twig',[
            'form'=>$form->createView(),
            'user'=>$user
        ]);
    }

    #[Route('recruteur/edit/{id}','recruteur.edit', methods:['GET','POST'])]
    
    public function edit(Recruteur $recruteur, Request $request,EntityManagerInterface $manager):Response
    {
        $user=$this->getUser();

        if($user !=  $recruteur->getUserRecrutueur()){
            return $this->redirectToRoute('recruteur.index');
        }
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


    // #[Route('recruteur/annonce/{id}','recruteur.annonce', methods:['GET','POST'])]
    // #[IsGranted('ROLE_RECRUTEUR')]
    // public function annonce(AnnonceRepository $repository,PaginatorInterface $paginator,Request $request,int $id):Response
    // {
       
    //      /**
    //     * @var Annonce
    //      */
    //     $annonces  = $repository->findBy(["recruteur"=>$id]);
    //     $user=$this->getUser();
    //     // dd( $user);
    //     if($user !=  $annonces->getUseAnnonce()){
    //         return $this->redirectToRoute('recruteur.index');
    //     }
       
    //     return $this->render('pages/recruteur/annonce/index.html.twig',[
    //         'annonces'=>$annonces,
    //         'id'=>$id
    //     ]);
    // }

    #[Route('/recruteur/annonce/new/{id}','recruteur.annonce.new',methods:['GET', 'POST'])]
    #[IsGranted('ROLE_RECRUTEUR')]
    public function newAnnonce(RecruteurRepository $repository, Request $request, EntityManagerInterface $manager,int $id):Response
    {

        $recruteur =$repository->findOneBy(["id"=>$id]);
         $user=$this->getUser();

        if($user !=  $recruteur->getUserRecrutueur()){
            return $this->redirectToRoute('recruteur.index');
        }
        // dd( $partenaires);
        $annonces = new annonce();
        $form = $this->createForm(RecruteurAnnonceType::class,$annonces);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $annonces = $form->getData();
            $annonces->setActive(false);
            $annonces ->setRecruteur($recruteur);
            $annonces ->setUseAnnonce($this->getUser());
            $manager->persist( $annonces);
            $manager->flush();
            
            $this->addFlash(
               'success',
               'Votre annonce à été céer avec succes !'
            );
            return $this->redirectToRoute('recruteur.index');
      
        }
        
        return $this->render('pages/recruteur/annonce/new.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/recruteur/annonce/edit/{id}/{id1}','recruteur.annonce.edit',methods:['GET', 'POST'])]
    #[IsGranted('ROLE_RECRUTEUR')]
    public function editAnnonce(RecruteurRepository $repository1,AnnonceRepository $repository, int $id, int $id1,Request $request,EntityManagerInterface $manager):Response
    {

        $recruteur =$repository1->findOneBy(["id"=>$id]);
        
        $annonces =$repository->findOneBy(["id"=>$id1]);
        $user=$this->getUser();
        // dd( $user);
        if($user !=  $annonces->getUseAnnonce()){
            return $this->redirectToRoute('recruteur.index');
        }
   
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
            return $this->redirectToRoute('recruteur.index');
        }

        return $this->render('pages/recruteur/annonce/edit.html.twig',[
            'form' => $form->createView(),
            'recruteur' => $recruteur

        ]);
    }

    #[Route('/recruteur/annonce/suppression/{id}/{id1}','recruteur.annonce.delete', methods :['GET'])]
    
    public function delete(EntityManagerInterface $manager,Annonce $annonces,int $id, int $id1):Response
    {
        $user=$this->getUser();
        // dd( $user);
        if($user !=  $annonces->getUseAnnonce()){
            return $this->redirectToRoute('recruteur.index');
        }
        
       $manager->remove($annonces);
       $manager->flush();
       $this->addFlash(
           'success',
           'Votre ingrédient à été supprimer avec succes !'
        );
        return $this->redirectToRoute('recruteur.annonce', ['id' =>$id ]);
    }

}
