<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use App\Entity\Burger;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ApFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i <=10 ; $i++) { 
            $burger = new Menu();
            $burger->setNomMenu("veggie king XXL");
            $manager->persist($burger);
        }
        for ($i=0; $i <=10 ; $i++) { 
            $burger = new Burger();
            $burger->setPrix(2500)
                     ->setNomBurger("burger simple");
            $manager->persist($burger);
        }
        $manager->flush();
    }
}
