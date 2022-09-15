<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user.index')]
    public function index(UserRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
      
        $users  = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        return $this->render('pages/user/index.html.twig', [
            'users' => $users
        ]);
    }


    #[Route('/user/edition/{id}', name: 'user.edit')]
    #[Security("is_granted('ROLE_USER') and user === choosenUser")]
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
                    'Les modifications de votre compte ont été modifiés'
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


  
    #[Route('/user/edition-mot-de-passe/{id}', 'user.edit.password', methods:['GET','POST'])]
    #[Security("is_granted('ROLE_USER') and user === choosenUser")]
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


    #[Route('/user/suppression/{id}','user.delete', methods :['GET'])]
    
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
