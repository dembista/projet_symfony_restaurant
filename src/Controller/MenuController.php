<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Image;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }
    #[Route('/menu', name: 'add_menu')]
    #[Route('/menu/edit/{id}', name: 'edit_burger')]
    public function create(?Menu $menu,Request $request, MenuRepository $repo){
        // if(!$burger){
        //     $burger = new burger();
        // }
        if(!$menu){
            $menu = new Menu();
        }
        $form=$this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // $images = $form->get('images')->getData();
            // foreach ($images as  $image) {
            //     $fichier = md5(uniqid()).''.$image->guessExtension();
            //     $image->move(
            //         $this->getParameter('images_directory'),
            //         $fichier
            //     );
            //     $img = new Image();
            //     $img->setNomImage($fichier);
            //     $burger->addImage($img);
            // }
            $menu = $form->getData();
            //dd($burger);
            $repo->add($menu);
            $this->addFlash('message','burger modifier avec succés');
            //dd($burger);
            return $this->redirectToRoute('add_menu');
            
        }
        return $this->render('menu/index.html.twig',[
            'form'=>$form->createView()

        ]);
    }
    #[Route('/remove/{id}', name: 'remove')]
    public function delete(Menu $menu, MenuRepository $repo){
                   $repo->remove($menu);
                   
                 //dd($repo);
                 //$repo->flush(); 
          return  $this->redirectToRoute('showburger_security');    
        //return $this->render('burger/index.html.twig', [
            
    }
}
