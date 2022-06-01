<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Burger;
use App\Entity\Commande;
use App\Entity\Payement;
use App\Form\BurgerType;
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
    

//     #[Route('/panier',name:'app_panier')]
//     public function panier(SessionInterface $session,BurgerRepository $burger,Request $request,MenuRepository $menu,UserRepository $user,EntityManagerInterface $entityManager)
//     {
//         $method = $request->getMethod();
//         $commande = new Commande();
//         $payement = new Payement();
//         $panier=$session->get('panier',[]);
//         $panierData = [];
//         $idBurger=[];
//         $idMenu=[];        
//         foreach($panier as $id => $quantity){
//             if(str_contains($id , 'burger')){
//                 $idBurger [] = (int) filter_var($id,FILTER_SANITIZE_NUMBER_INT);
//             }else{
//                 $idMenu [] = (int) filter_var($id,FILTER_SANITIZE_NUMBER_INT);
//             }


//             $panierData[] = [
//                 'burger'=>str_contains($id, "burger") ? $burger->find($id) :$menu->find($id),
//                 'quantity'=> $quantity,
//             ]; 
//             //dd($panierData);
//         }
        
//         $total=0;
       

         
// if ($method == 'POST') {
//     $date = date_format(date_create() , 'Y-m-d');

//     $idUser = array_values((array)$this->getUser())[0];
//     $user = $user->find($idUser);
    

//     $payement-> setMontant(0);
//     $commande->setDate($date) 
//             //->setNumero(rand())
//             ->setEtat('demander')
//             ->setValider(0)
//             ->setUser($this->getUser())
//             ->setPayements($payement);

//     if(count($idBurger)>0){
//         foreach ($idBurger as $val) {
//             $commande->addBurger($burger->find($val));
//         }
//     }       
//     if(count($idMenu)>0){
//         foreach ($idMenu as $val2) {
//             $commande->addMenu($menu->find($val2));
//         }
//     } 
       
//     $entityManager->persist($payement);
//     $entityManager->persist($commande);
//     $entityManager->flush();
//         }
//       //  dd($panierData);
//         return $this -> render('catalogue/panier.html.twig',[
//          'datas'=>$panierData,
//          'total'=>$total,
//         ]);
//     }

//     #[Route('/panier/add/{id}',name:'app_add_panier')]
//     public function addBurgerPanier( $id, SessionInterface $session)
//     {
//             $panier=$session->get('panier',[]);

//            if(!empty($panier[$id])){

//                $panier[$id]++;
//            }else{

//                 $panier[$id] = 1;        
//            }
//            $session->set('panier', $panier);
//           // dd($session->get('panier'));
//           return $this->redirectToRoute('catalogue_burger');
//     }

//     #[Route('/panier/remove/{id}',name:'app_remove_panier')]
//     public function remove_panier( $id, SessionInterface $session)
//     {
//         $panier=$session->get('panier',[]);
//         if(!empty($panier[$id])){

//            unset( $panier[$id]);
//         }
//         $session->set('panier', $panier);
//         return $this-> redirectToRoute('app_panier');
//     }
   
    // #[Route('/panier/burger',name:'app_panier_burger')]
    // public function panier(SessionInterface $session,BurgerRepository $burgerRepository)
    // {
    //     $panier=$session->get('panier',[]);
    //     $panierData = [];
    //     foreach($panier as $id => $quantity){
    //         $panierData[] = [
    //             'burger'=>$burgerRepository->find($id),
    //             'quantity'=> $quantity,
    //         ];
    //     }
    //     $total=0;
    //     foreach ($panierData as $data) {
    //         $totalData = $data['burger']->getPrix() * $data['quantity'];
    //         $total += $totalData;
    //     }
    //   //  dd($panierData);
    //     return $this -> render('catalogue/panier.html.twig',[
    //      'datas'=>$panierData,
    //      'total'=>$total,
    //     ]);
    // }

    // #[Route('/panier/add/{id}',name:'app_add_panier')]
    // public function addPanier(int $id, SessionInterface $session)
    // {
    //         $panier=$session->get('panier',[]);

    //        if(!empty($panier[$id])){

    //            $panier[$id]++;
    //        }else{

    //             $panier[$id] = 1;        
    //        }
    //        $session->set('panier', $panier);
    //       // dd($session->get('panier'));
    //       return $this->redirectToRoute('catalogue_burger');
    // }

    // #[Route('/panier/remove/{id}',name:'app_remove_panier')]
    // public function remove_panier(int $id, SessionInterface $session)
    // {
    //     $panier=$session->get('panier',[]);
    //     if(!empty($panier[$id])){

    //        unset( $panier[$id]);
    //     }
    //     $session->set('panier', $panier);
    //     return $this-> redirectToRoute('app_panier_burger');
    // }

    #[Route('/gestionnaire/archiveBurgs/{id}')]
    public function archivBur(Burger $burger ,EntityManagerInterface $manager): Response{
        $burger ->setEtat('archiver');
        //dd($burger);
        $manager->persist($burger);
        $manager->flush();

        return $this->redirectToRoute('archives');
    }
    
    #[Route('/gestionnaire/archiverBurg', name: 'archives')]
    public function archiveBur(BurgerRepository $em,PaginatorInterface $paginator, Request $request): Response
    {

        $burger = $paginator->paginate(
            $em->findBy(['etat'=>'archiver']),
            $request->query->getInt('page', 1), 
            5
        );
        
          return $this->render('burger/archiverBurger.html.twig', [
            "burger"=>$burger,
          ]);
          
      } 
}
