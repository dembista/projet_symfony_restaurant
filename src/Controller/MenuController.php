<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Image;
use App\Form\MenuType;
use App\Entity\Commande;
use App\Entity\Payement;
use App\Repository\MenuRepository;
use App\Repository\UserRepository;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    #[Route('/menu/add', name: 'add_menu')]
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
             $images = $form->get('images')->getData();
             foreach ($images as  $image) {
                 $fichier = md5(uniqid()).''.$image->guessExtension();
                 $image->move(
                     $this->getParameter('images_directory'),
                     $fichier
                 );
                 $img = new Image();
                 $img->setNomImage($fichier);
                 $menu->addImage($img);
             }
            $menu = $form->getData();
            //dd($menu);
            $repo->add($menu);
            //$this->addFlash('message','menu modifier avec succés');
            //dd($burger);
            return $this->redirectToRoute('app_lister_menu');
            
        }
        return $this->render('menu/ajoutMenu.html.twig',[
            'form'=>$form->createView(),    

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
    #[Route('/panier',name:'app_panier')]
    public function panier(SessionInterface $session,BurgerRepository $burger,Request $request,MenuRepository $menu,UserRepository $user,EntityManagerInterface $entityManager)
    {
        $method = $request->getMethod();
        $commande = new Commande();
        $payement = new Payement();
        $panier=$session->get('panier',[]);
        $panierData = [];
        $idBurger=[];
        $idMenu=[];        
        foreach($panier as $id => $quantity){
            if(str_contains($id , 'burger')){
                $idBurger [] = (int) filter_var($id,FILTER_SANITIZE_NUMBER_INT);
            }else{
                $idMenu [] = (int) filter_var($id,FILTER_SANITIZE_NUMBER_INT);
            }


            $panierData[] = [
                'burger'=>str_contains($id, "burger") ? $burger->find($id) :$menu->find($id),
                'quantity'=> $quantity,
            ]; 
            //dd($panierData);
        }
        
        $total=0;
        foreach ($panierData as $datas) {
            //dd($data);
            $totalData = $datas['burger']->getPrix() * $datas['quantity'];
            $total += $totalData;
        }

         
if ($method == 'POST') {
    //dd('tester');
    $date = date_format(date_create() , 'Y-m-d');

    $idUser = array_values((array)$this->getUser())[0];
    $user = $user->find($idUser);
    $montant = $total;

   

    $commande->setDate($date) 
            ->setEtat('En cours')
            ->setValider(0)
            ->setMontant($montant)
            ->setUser($this->getUser())
            ->setPayements($payement);
    $payement-> setMontant($montant)
            ->setDate($date);
    if(count($idBurger)>0){
        foreach ($idBurger as $val) {
            $commande->addBurger($burger->find($val));
        }
    }       
    if(count($idMenu)>0){
        foreach ($idMenu as $val2) {
            $commande->addMenu($menu->find($val2));
        }
    } 
    //dd($payement);
    //dd($commande);
    
    $entityManager->persist($commande);
    $entityManager->persist($payement);
    $entityManager->flush();
        }
      //  dd($panierData);
        return $this -> render('catalogue/panier.html.twig',[
         'datas'=>$panierData,
         'total'=>$total,
        ]);
    }

    #[Route('/panier/add/{id}',name:'app_add_panier')]
    public function addBurgerPanier( $id, SessionInterface $session)
    {
            $panier=$session->get('panier',[]);

           if(!empty($panier[$id])){

               $panier[$id]++;
           }else{

                $panier[$id] = 1;        
           }
           $session->set('panier', $panier);
          // dd($session->get('panier'));
          return $this->redirectToRoute('catalogue_burger');
    }

    #[Route('/panier/remove/{id}',name:'app_remove_panier')]
    public function remove_panier( $id, SessionInterface $session)
    {
        $panier=$session->get('panier',[]);
        if(!empty($panier[$id])){

           unset( $panier[$id]);
        }
        $session->set('panier', $panier);
        return $this-> redirectToRoute('app_panier');
    }
    #[Route('/details/{id}', name: 'detail_menu')]
    public function details(MenuRepository $em): Response
    {
        $menu = $em->findAll();

        return $this->render('catalogue/details.html.twig', [
            "menu"=> $menu,
        ]);
    }

    #[Route('/gestionnaire/archiverMenu/{id}', name: 'archiver_burger')]
    public function archivBur(Menu $menu ,EntityManagerInterface $manager): Response{
        $menu ->setEtat('archiver');
        $manager->persist($menu);
        $manager->flush();

        return $this->redirectToRoute('archiver');
    }
    
    #[Route('/gestionnaire/archiveMenu', name: 'archiver')]
    public function archiveBur(MenuRepository $em,PaginatorInterface $paginator, Request $request): Response
    {

        $burger = $paginator->paginate(
            $em->findBy(['etat'=>'archiver']),
            $request->query->getInt('page', 1), 
            5
        );
        
          return $this->render('menu/archiverMenu.html.twig', [
            "burger"=>$burger,
          ]);
          
      }
}
