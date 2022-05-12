<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Burger;
use App\Form\BurgerType;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BurgerController extends AbstractController
{
    #[Route('/', name: 'catalogue_burger')]
    public function catalogue(BurgerRepository $em, MenuRepository $test): Response
    {
        $burger = $em->findAll();
        $menu = $test->findAll();

        return $this->render('catalogue/catalogue.html.twig', [
            "burger"=> $burger,
            "menu"=> $menu,
        ]);
    }
    #[Route('/details/{id}', name: 'detail_burger')]
    public function details(BurgerRepository $em): Response
    {
        $burger = $em->findAll();

        return $this->render('catalogue/details.html.twig', [
            "burger"=> $burger,
        ]);
    }
    #[Route('/burger', name: 'add_burger')]
    #[Route('/burger/edit/{id}', name: 'edit_burger')]
    public function create(?Burger $burger,Request $request, BurgerRepository $repo){
        // if(!$burger){
        //     $burger = new burger();
        // }
        if(!$burger){
            $burger = new Burger();
        }
        $form=$this->createForm(BurgerType::class, $burger);
       
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach ($images as  $image) {
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Image();
                $img->setNomImage($fichier);
                 $burger->addImage($img);
            }
            
            $burger = $form->getData();
            //dd($burger);
            dd($burger);
            $repo->add($burger);
            //$repo->addBurger($burger);
           
            $this->addFlash('message','burger modifier avec succés');
            //dd($burger);
            return $this->redirectToRoute('add_burger');
            
        }
        return $this->render('burger/index.html.twig',[
            'form'=>$form->createView()

        ]);
    }
    #[Route('/remove/{id}', name: 'remove')]
    public function delete(Burger $burger, BurgerRepository $repo){
                   $repo->remove($burger);
                   
                 //dd($repo);
                 //$repo->flush(); 
          return  $this->redirectToRoute('showburger_security');    
        //return $this->render('burger/index.html.twig', [
            
    }
}
