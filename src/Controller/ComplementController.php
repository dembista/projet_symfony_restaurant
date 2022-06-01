<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Complement;
use App\Form\ComplementType;
use App\Repository\ComplementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComplementController extends AbstractController
{
    #[Route('/complement', name: 'app_complement')]
    public function index(): Response
    {
        return $this->render('complement/index.html.twig', [
            'controller_name' => 'ComplementController',
        ]);
    }
    #[Route('/complement', name: 'add_complement')]
    #[Route('/complement/edit/{id}', name: 'edit_burger', methods: ['POST'])]
    public function create(?Complement $complement,Request $request, ComplementRepository $repo){
        // if(!$burger){
        //     $burger = new burger();
        // }
        //dd('tester');
        if(!$complement){
            $complement = new Complement();
        }
        $form=$this->createForm(ComplementType::class, $complement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach ($images as  $image) {
                $fichier = md5(uniqid()).''.$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Image();
                $img->setNomImage($fichier);
                $complement->addImage($img);
            }
            $complement = $form->getData();
            //dd($burger);
            $repo->add($complement);
            $this->addFlash('message','complement modifier avec succés');
            //dd($burger);
            return $this->redirectToRoute('add_complement');
            
        }
        
        return  $this->render('complement/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
    #[Route('/remove/{id}', name: 'remove')]
    public function delete(Complement $complement, ComplementRepository $repo){
                   $repo->remove($complement);
                   
                 //dd($repo);
                 //$repo->flush(); 
          return  $this->redirectToRoute('showburger_security');    
        //return $this->render('burger/index.html.twig', [
            
    }
}
