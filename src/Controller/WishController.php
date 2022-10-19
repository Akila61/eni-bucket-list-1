<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish')]
class WishController extends AbstractController
{

    #[Route('/', name: 'wish_list')]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig', [
            'controller_name' => 'WishController',
        ]);
    }

    #[Route('/wish/{id}', name: 'wish_detail', requirements: ['id' => '\d+'],)]
    public function detail(int $id): Response
    {
        return $this->render('wish/detail.html.twig', [
            'id' => $id,
        ]);
    }
}
