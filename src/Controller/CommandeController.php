<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(CommandeRepository $em, PaginatorInterface $paginator, Request $request): Response
    {

        $commandes=$paginator->paginate(
            $em->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('commande/listerCommande.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
