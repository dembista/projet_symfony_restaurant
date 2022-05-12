<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//#[Route('/admin', name: 'app_admin')]
class AdminController extends AbstractController
{
    
    #[Route('/listerBurger', name: 'app_lister_burger')]
    public function index(BurgerRepository $em): Response
    {
        $burg = $em->findAll();
        return $this->render('burger/listerBurger.html.twig', [
            'burg' => $burg,
        ]);
    }
    #[Route('/listerMenu', name: 'app_lister_menu')]
    public function menu(MenuRepository $em): Response
    {
        $men = $em->findAll();
        return $this->render('menu/listerMenu.html.twig', [
            'men' => $men,
        ]);
    }
}
