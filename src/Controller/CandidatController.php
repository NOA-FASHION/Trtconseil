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
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
class CandidatController extends AbstractController
{
    #[Route('/candidat', name: 'index.candidat', methods : ['GET'])]
    #[IsGranted('ROLE_CANDIDAT')]
    public function index(AnnonceRepository $repository1,CandidatRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
           /**
        * @var User
         */
        $user=$this->getUser();
      
        if($user->getRoles()[0] != "ROLE_CANDIDAT"){
            return $this->redirectToRoute('home.index');
        }
        $candidat = $repository->findOneBy(['userCandidat'=> $this->getUser()]);
        
        
        if($candidat === null){
            return $this->redirectToRoute('candidat.new');
        }
        

        $annonces = $paginator->paginate(
            $repository1->findBy(["active"=>true]), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('pages/candidat/index.html.twig', [
            'candidat' => $candidat,
            'annonces'=>$annonces,
        ]);
    }

    #[Route('candidat/new','candidat.new',methods:['GET', 'POST'])]
    #[IsGranted('ROLE_CANDIDAT')]
    public function new(Request $request,EntityManagerInterface $manager,SluggerInterface $slugger):Response
    {
        $user=$this->getUser();
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);
        if($form->isSubmitted()  && $form->isValid()){
            /** @var UploadedFile $cvLien */
            $cvLien = $form->get('cvLien')->getData();

            if ($cvLien) {
                $originalFilename = pathinfo($cvLien->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$cvLien->guessExtension();
                try {
                    $cvLien->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
            }
                

            $candidat = $form->getData();
            $candidat->setCvLien($newFilename);

            $candidat->setActivation(false);
            $candidat->setUserCandidat( $user);
            $manager->persist($candidat);
            $manager->flush();
            $this->addFlash(
                'success',
                'le candidat ?? ??t?? cr??er avec succes !'
             );
            return $this->redirectToRoute('index.candidat');
        }

        return $this->render('pages/candidat/new.html.twig',[
            'form'=>$form->createView(),
            'user'=>$user,
           
        ]);
    }

    #[Route('candidat/edit/{id}','candidat.edit', methods:['GET','POST'])]
    #[IsGranted('ROLE_CANDIDAT')]
    public function edit(Candidat $candidat, Request $request,EntityManagerInterface $manager,SluggerInterface $slugger):Response
    {
        $form = $this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
             /** @var UploadedFile $cvLien */
             $cvLien = $form->get('cvLien')->getData();

             if ($cvLien) {
                 $originalFilename = pathinfo($cvLien->getClientOriginalName(), PATHINFO_FILENAME);
                 $safeFilename = $slugger->slug($originalFilename);
                 $newFilename = $safeFilename.'-'.uniqid().'.'.$cvLien->guessExtension();
                 try {
                     $cvLien->move(
                         $this->getParameter('brochures_directory'),
                         $newFilename
                     );
                 } catch (FileException $e) {
                 }
             }
                 
 
             $candidat = $form->getData();
             $candidat->setCvLien($newFilename);
            $manager->persist($candidat);
            $manager->flush();
            $this->addFlash(
                'success',
                'Vos infromations ont ??t?? modifier avec succes !'
             );
             return $this->redirectToRoute('index.candidat');
             
        }

        return $this->render('pages/candidat/edit.html.twig',[
            'form' => $form->createView(),
            
        ]);
    }

    #[Route('candidat/annonce/','candidat.annonce', methods:['GET','POST'])]
    #[IsGranted('ROLE_CANDIDAT')]
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
