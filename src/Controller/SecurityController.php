<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'security.login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }


    #[Route('/deconnexion', 'security.logout')]
    public function logout()
    {
    }

    #[Route('/inscription','security.registration', methods:['GET','POST'] )]
    public function registration(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new User();
        
        $form = $this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()){
            $user = $form->getData();
            if ($user->isIsRecruteur()){
                $user->setRoles(['ROLE_RECRUTEUR']);
            }else{
                $user->setRoles(['ROLE_CANDIDAT']);
            }
            $this->addFlash(
                'success',
                'Votre compte à été crée avec succes !'
             );
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security.login');
        }

        return $this->render('pages/security/registration.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
