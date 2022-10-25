<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish')]
class WishController extends AbstractController
{

    #[Route('/', name: 'wish_list')]
    public function list(WishRepository $wishRepository): Response
    {
        // Récupérer la liste des souhaits
        $wishes = $wishRepository->findAll();

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/{id}', name: 'wish_detail', requirements: ['id' => '\d+'])]
    public function detail(WishRepository $wishRepository, int $id): Response
    {
        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }
    #[Route('/new-wish', name: 'new_wish', methods:['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $wish -> setIsPublished(true);
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

            $this->addFlash('success', 'Le souhait a bien été créé');

            // Rediriger l'internaute vers la liste des séries
            return $this->redirectToRoute('wish_detail', ['id' =>$wish->getId()]);
        }

        return $this->render('main/new.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);
    }

    #[Route('/update/{id}', name: 'wish_update', requirements: ['id'=>'\d+'], methods:['GET','POST'])]
    public function update(Request $request, EntityManagerInterface $em, Wish $wish): Response
    {
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $em->persist($wish);
            $em->flush();

            $this->addFlash('success', 'Le souhait a bien été modifié');

            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }

        return $this->render('wish/update.html.twig', [
            'wish' => $wish,
            'wishForm' => $wishForm->createView()
        ]);
    }
    #[Route('/delete/{id}', name: 'wish_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $em, Wish $wish): Response
    {
        if ($this->isCsrfTokenValid('delete' . $wish->getId(), $request->request->get('_token'))) {
            $em->remove($wish);
            $em->flush();
        } else {
            $this->addFlash('error', 'Le token CSRF est invalide !');
        }

        return $this->redirectToRoute('wish_list');
    }

}
