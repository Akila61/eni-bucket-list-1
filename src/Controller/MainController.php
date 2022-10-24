<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\Wish;
use App\Form\SerieType;
use App\Form\WishType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/new-wish', name: 'new_wish')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $wish->setDateCreated(new \DateTime()); // Ou utiliser les LifeCycleCallbacks de Doctrine
        $wishForm = $this->createForm(WishType::class, $wish);

        // Récupération des données pour les insérer dans l'objet $serie
        $wishForm->handleRequest($request);
        dump($wish);

        // Vérifier si l'utilisateur est en train d'envoyer le formulaire
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            // Enregistrer la nouvelle série en BDD
            $em->persist($wish);
            $em->flush();

            $this->addFlash('success', 'l\'idée a bien été créée !');

            // Rediriger l'internaute vers la liste des séries
            return $this->redirectToRoute('homepage');
        }

        return $this->render('main/new.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);
    }
}