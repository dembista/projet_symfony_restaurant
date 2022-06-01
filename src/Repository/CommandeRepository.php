<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
        //$this->session = $session;
        //$this->repo = $repo;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Commande $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function addCart($id){
        $cart = $this->getCart();
        if (isset($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]++ ;
            }
        }else {
            $cart[$id] = 1;
        }
        $this->updateCart($cart);
    }
    public function deleteFromCart($id){
        $cart = $this->getCart();
        if (isset($cart[$id])) {
            $cart[$id]-- ;
        }else {
            
            unset($cart[$id]);
        }
        $this->updateCart($cart);
    }
    public function deleteAllToCart($id){
        $cart = $this->getCart();
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        $this->updateCart($cart);
    }
    public function deleteCart(){
        $this->updateCart([]);
    }
    public function updateCart($cart){
        $this->session('cart',$cart);
        $this->session('cartData', $this->getFullCart());
    }
    public function getCart(){
      return  $this->session->get('cart',[]);
    }
    public function getFullCart(){
        $cart = $this->getCart();
        $fullCart = [];
        $quantityCart = 0;
        $subTotal = 0;
        foreach ($cart as $id => $quantity) {

            $burger = $this->repo->find($id);
            if ($burger) {
                $fullCart['burger'][]=[
                    'quantity' => $quantity,
                    'burger' => $burger
                ];
                $quantityCart += $quantity;
                $subTotal += $quantity * $burger->getPrix()/100;
            }else {
                $this->deleteFromCart($id);
            }
        }
        $fullCart['data'] = [
            'quantityCart' => $quantityCart,
            'subTotalHT' => $subTotal,
            'taxed' => round($subTotal*$this->tva,2),
            'subTotalTTC' => round(($subTotal)+($subTotal*$this->tva),2)
        ];
        return $fullCart;
    }
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Commande $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

//    /**
//     * @return Commande[] Returns an array of Commande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Commande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
