<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig');
    }

    #[Route( '/about_us', name: 'about_us')]
    public function aboutUs(): Response
    {
        return $this->render('main/about_us.html.twig');
    }

    #[Route( '/legal-stuff', name: 'main_legal')]
    public function legal(): Response
    {
        return $this->render('main/legal.html.twig');
    }
}