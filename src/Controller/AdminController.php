<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Entity\Commande;
use App\Form\BurgerType;
use App\Repository\MenuRepository;
use App\Repository\UserRepository;
use App\Repository\BurgerRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    
    #[Route('/gestionnaire/listerBurger', name: 'app_lister_burger')]
    public function index(BurgerRepository $em, PaginatorInterface $paginator, Request $request): Response
    {
        $burg=$paginator->paginate(
            $em->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('burger/listerBurger.html.twig', [
            'burg' => $burg,
        ]);
    }
    #[Route('/gestionnaire/listerMenu', name: 'app_lister_menu')]
    public function menu(MenuRepository $em, PaginatorInterface $paginator, Request $request): Response
    {
        $menu=$paginator->paginate(
            $em->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('menu/listerMenu.html.twig', [
            'menu' => $menu,
        ]);
    }
    #[Route('/gestionnaire/burger/add', name: 'add_burger')]
    #[Route('/gestionnaire/burger/edit/{id}', name: 'edit_burger')]
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
            // $images = $form->get('images')->getData();
            // foreach ($images as  $image) {
            //     $fichier = md5(uniqid()).'.'.$image->guessExtension();
            //     $image->move(
            //         $this->getParameter('images_directory'),
            //         $fichier
            //     );
            //     $img = new Image();
            //     //$burger_id= $burger->getId();
            //     $img->setNomImage($fichier);
            //     // $burger->addImage($img);
            // }
            
            $burger = $form->getData();
            //dd($burger);
            //dd($burger);
            //$repo->add($burger);
            $repo->addBurger($burger);
           
            //$this->addFlash('message','burger modifier avec succés');
            //dd($burger);
            return $this->redirectToRoute('add_burger');
            
        }
        return $this->render('burger/index.html.twig',[
            'form'=>$form->createView()

        ]);
    }
    #[Route('/gestionnaire/remove/{id}', name: 'remove')]
    public function delete(Burger $burger, BurgerRepository $repo){
                   $repo->remove($burger);
                   
                 //dd($repo);
                 //$repo->flush(); 
          return  $this->redirectToRoute('showburger_security');    
        //return $this->render('burger/index.html.twig', [
            
    }
    // #[Route('/listerUser', name: 'app_lister_user')]
    // public function users(UserRepository $em): Response
    // {
    //     $users = $em->findAll();
    //     return $this->render('menu/listerMenu.html.twig', [
    //         'users' => $users,
    //     ]);
    // }
//     #[Route('/AC/inscription/classe', name: 'iscription_filtre_classe')]
//    public function showInscriptionByClasse(
//                          CommandeRepository $repoCom,
//                          SessionInterface $session,
//                          Request $request ): Response
//    {
 
//        if($request->isXmlHttpRequest()) {
         
//            $etat = $repoCom->findBy([
//                'etat'=>$etat
//            ]);
          
//            $session->set("etat", $etat);
//        }
 
//        return new JsonResponse($this->generateUrl('inscription_show'));
//    }
#[Route('gestionnaire/commande', name: 'app_commande_gestionnaire')]
    public function liste(CommandeRepository $em, PaginatorInterface $paginator, Request $request): Response
    {

        $commandes=$paginator->paginate(
            $em->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('gestionnaire/listerCommande.html.twig', [
            'commandes' => $commandes,
        ]);
    }
    #[Route('/gestionnaire/annulerCommande/{id}')]
    public function annulerCommande(Commande $commandes ,EntityManagerInterface $manager): Response{
        $commandes ->setEtat('Annuler');
        //dd($burger);
        $manager->persist($commandes);
        $manager->flush();

        return $this->redirectToRoute('app_commande_gestionnaire');
    }
    #[Route('/gestionnaire/validerCommande/{id}')]
    public function validerCommande(Commande $commandes ,EntityManagerInterface $manager): Response{
        $commandes ->setEtat('Terminer')
                   ->setValider(1);
        //dd($burger);
        $manager->persist($commandes);
        $manager->flush();

        return $this->redirectToRoute('app_commande_gestionnaire');
    }

}
