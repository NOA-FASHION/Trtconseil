<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    #[Route('/', 'home.index', methods : ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/home.html.twig');
    }
}