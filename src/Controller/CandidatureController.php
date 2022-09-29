<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidatureController extends AbstractController
{
    #[Route('/candidature/new/{id}/{id1}', name: 'candidature.new')]
    public function new(
        CandidatureRepository $repository2,
        AnnonceRepository $repository1,
        CandidatRepository $repository,
        Request $request,
        EntityManagerInterface $manager,
        int $id,
        int $id1
    ): Response {
       
        $candidat = $repository->findOneBy(['id' => $id]);
        $annonce = $repository1->findOneBy(['id' => $id1]);
        $annonceCandidature = $repository->findCandidatforAnnonce($annonce,$id);
      

        if ($candidat == $annonceCandidature) {
            return $this->redirectToRoute('candidature.postule', ['id' =>$id ]);
        }else{$candidat->addAnnonce($annonce);
           
            $manager->persist($candidat);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre candidature à été crée avec succes !'
            );
            return $this->redirectToRoute('index.candidat');}
            
            
     
    }

    #[Route('candidature/postule/{id}','candidature.postule', methods:['GET','POST'])]
    
    public function annonce(CandidatRepository $repository,int $id):Response
    {
        

        return $this->render('pages/candidature/index.html.twig');
    }
}
