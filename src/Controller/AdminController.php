<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Consultant;
use App\Form\ConsultantType;
use App\Form\RegistrationType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use App\Form\RegistrationConsultantType;
use App\Repository\ConsultantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin.index')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $repository,PaginatorInterface $paginator,Request $request): Response
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
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request,EntityManagerInterface $manager):Response
    {
        $user = new User();
        
        $form = $this->createForm(RegistrationConsultantType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()){
            $user = $form->getData();
             $user->setRoles(['ROLE_CONSULTANT']);
             $user->setIsRecruteur(false);
            $this->addFlash(
                'success',
                'Votre compte à été crée avec succes !'
             );
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('admin.index');
        }


        return $this->render('pages/admin/new.html.twig',[
            'form'=>$form->createView()
        ]);
    }

   
    #[Route('admin/user/edition/{id}', name: 'admin.user.edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edition(User $choosenUser, Request $request, EntityManagerInterface $manager,UserPasswordHasherInterface $hasher): Response
    {
       
        $form =$this->createForm(UserType::class, $choosenUser);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            if($hasher->isPasswordValid($choosenUser,$form->getData()->getPlainPassword()))
            {
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Les modifications de votre compte ont été éffectués'
                );
                return $this->redirectToRoute('user.index');
            }else{
                $this->addFlash(
                    'Warning',
                    'Le mot de passe renseigné est incorrect'
                );
            }

          
           
        }
        return $this->render('/pages/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


  
    #[Route('admin/user/edition-mot-de-passe/{id}', 'admin.user.edit.password', methods:['GET','POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function editPassword(User $choosenUser, Request $request,UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($hasher->isPasswordValid($choosenUser, $form->getData()['plainPassword']))
            {

                 $choosenUser->setPassword(
                    $hasher->hashPassword(
                        $choosenUser,
                        $form->getData()['newPassword']
                    )
                    );       

                $this->addFlash(
                    'success',
                    'Le mot de passe à été modifié'
                );
                $manager->persist($choosenUser);
                $manager->flush();
                return $this->redirectToRoute('user.index');
            }else{
                $this->addFlash(
                    'Warning',
                    'Le mot de passe renseigné est incorrect'
                );
            }
        }
        
        return $this->render('pages/user/edit_password.html.twig',[
            'form'=> $form->createView()
        ]);
    }


    #[Route('admin/user/suppression/{id}','admin.user.delete', methods :['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(EntityManagerInterface $manager,User $choosenUser):Response
    {
       $manager->remove($choosenUser);
       $manager->flush();
       $this->addFlash(
           'success',
           'Votre utilisateur à été supprimer avec succes !'
        );
        return $this->redirectToRoute('user.index');
    }
}
