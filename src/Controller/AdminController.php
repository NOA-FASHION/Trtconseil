<?php

namespace App\Controller;

use App\Entity\Consultant;
use App\Form\ConsultantType;
use App\Repository\ConsultantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin.index')]
    public function index(ConsultantRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {

        $consultants  = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('pages/admin/index.html.twig', [
            'consultants' => $consultants ,
        ]);
    }

    #[Route('admin/new','admin.new',methods:['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $manager):Response
    {
        $consultants = new Consultant();
        $form = $this->createForm(ConsultantType::class,$consultants);
        $form->handleRequest($request);
        if($form->isSubmitted()  && $form->isValid()){
            $consultants = $form->getData();
            $manager->persist($consultants);
            $manager->flush();
            $this->addFlash(
                'success',
                'le recruteur à été créer avec succes !'
             );
            return $this->redirectToRoute('index.candidat');
        }

        return $this->render('pages/admin/new.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('admin/edit/{id}','admin.edit', methods:['GET','POST'])]
    public function edit(Consultant $consultant, Request $request,EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(ConsultantType::class,$consultant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $consultant =$form->getData();
            $manager->persist($consultant);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre ingrédient à été modifier avec succes !'
             );
             return $this->redirectToRoute('admin.index');
             
        }

        return $this->render('pages/admin/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/suppression/{id}','admin.delete', methods :['GET'])]
    public function delete(EntityManagerInterface $manager,Consultant $consultant,):Response
    {
       $manager->remove($consultant);
       $manager->flush();
       $this->addFlash(
           'success',
           'Votre ingrédient à été supprimer avec succes !'
        );
        return $this->redirectToRoute('admin.index');
    }
}
