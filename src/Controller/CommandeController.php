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
        $user = array_values((array)$this->getUser())[0];
        $commandes=$paginator->paginate(
            $em->findBy(['etat'=>'En cours' , 'user' => $user]),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('commande/listerCommande.html.twig', [
            'commandes' => $commandes,
        ]);
    }
    #[Route('/commande/Annuler', name: 'app_commande_Annuler')]
    public function commandeAnnuler(CommandeRepository $em, PaginatorInterface $paginator, Request $request): Response
    {
        $user = array_values((array)$this->getUser())[0];
        $commandes=$paginator->paginate(
            $em->findBy(['etat'=>'Annuler' , 'user' => $user]),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('commande/listerCommande.html.twig', [
            'commandes' => $commandes,
        ]);
    }
    #[Route('/commande/Terminer', name: 'app_commande_terminer')]
    public function commandeTerminer(CommandeRepository $em, PaginatorInterface $paginator, Request $request): Response
    {
        $user = array_values((array)$this->getUser())[0];
        $commandes=$paginator->paginate(
            $em->findBy(['etat'=>'Terminer' , 'user' => $user]),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('commande/listerCommande.html.twig', [
            'commandes' => $commandes,
        ]);
    }
    // #[Route('/commande', name: 'app_commande')]
    // public function commandeUser(CommandeRepository $commande): Response
    // {
    //     $user = array_values((array)$this->getUser())[0];
    //     $commandes = $commande->findBy(['etat'=>'encours' , 'user' => $user]);
    //     return $this->render('commande/listerCommande.html.twig', [
    //         'controller_name' => 'CommandeController',
    //         'commandes'=>$commandes,
          
    //     ]);
    // }
}
