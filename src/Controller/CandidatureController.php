<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Repository\UserRepository;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidatureController extends AbstractController
{
    #[Route('/candidature/new/{id}/{id1}', name: 'candidature.new')]
    #[IsGranted('ROLE_CANDIDAT')]
    public function new(MailerInterface $mailer,
    UserRepository $repository2,
        AnnonceRepository $repository1,
        CandidatRepository $repository,
        Request $request,
        EntityManagerInterface $manager,
        int $id,
        int $id1,$publicDir
    ): Response {
       
        $candidat = $repository->findOneBy(['id' => $id]);
        $annonce = $repository1->findOneBy(['id' => $id1]);
        $annonceCandidature = $repository->findCandidatforAnnonce($annonce,$id);
        
         /**
        * @var User
         */
        $user=$repository2->findOneBy(['id' => $annonce->getUseAnnonce()]);
       
        if ($candidat == $annonceCandidature) {
            return $this->redirectToRoute('candidature.postule', ['id' =>$id ]);
        }else{$candidat->addAnnonce($annonce);
           
            $manager->persist($candidat);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre candidature à été crée avec succes !'
            );
            $email = (new TemplatedEmail())
            ->from('michel.almont@gmail.com')
            ->to("michel.almont972@gmail.com")
            ->attachFromPath($publicDir.'/uploads/brochures/'.$candidat->getCvLien())
            ->subject('Nouvelle candidature')
            ->htmlTemplate('mails/contact.html.twig')

            // pass variables (name => value) to the template
                ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'candidat' => $candidat,
                'annonce'=>$annonce
                ]);

            $mailer->send($email);
            return $this->redirectToRoute('index.candidat');}
            
            
     
    }

    #[Route('candidature/postule/{id}','candidature.postule', methods:['GET','POST'])]
    #[IsGranted('ROLE_CANDIDAT')]
    
    public function annonce(CandidatRepository $repository,int $id):Response
    {
        

        return $this->render('pages/candidature/index.html.twig');
    }
}
