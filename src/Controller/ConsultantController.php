<?php

namespace App\Controller;

use App\Repository\RecruteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    #[Route('/consultant/recruteur', name: 'recruteur.consultant',methods:['GET'])]
    public function recruteur(RecruteurRepository $repository,PaginatorInterface $paginator,Request $request): Response
    {
        $recruteurs = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('pages/consultant/recruteur.html.twig', [
            'recruteurs' =>  $recruteurs ,
        ]);
    }
}
