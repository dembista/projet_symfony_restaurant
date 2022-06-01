<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Burger;
use App\Form\Burger1Type;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/burg')]
class BurgController extends AbstractController
{
    #[Route('/', name: 'app_burg_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $burgers = $entityManager
            ->getRepository(Burger::class)
            ->findAll();

        return $this->render('burg/index.html.twig', [
            'burgers' => $burgers,
        ]);
    }

    #[Route('/new', name: 'app_burg_new', methods: ['GET', 'POST'])]
    public function new(?Burger $burger,Request $request, BurgerRepository $repo): Response
    {
        $burger = new Burger();
        $form = $this->createForm(Burger1Type::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();
            foreach ($images as  $image) {
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Image();
                //$burger_id= $burger->getId();
                $img->setNomImage($fichier);
                $burger->addImage($img);
            }
            $repo->add($burger);
            

            return $this->redirectToRoute('app_burg_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('burg/new.html.twig', [
            'burger' => $burger,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_burg_show', methods: ['GET'])]
    public function show(Burger $burger): Response
    {
        return $this->render('burg/show.html.twig', [
            'burger' => $burger,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_burg_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Burger $burger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Burger1Type::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_burg_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('burg/edit.html.twig', [
            'burger' => $burger,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_burg_delete', methods: ['POST'])]
    public function delete(Request $request, Burger $burger, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$burger->getId(), $request->request->get('_token'))) {
            $entityManager->remove($burger);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_burg_index', [], Response::HTTP_SEE_OTHER);
    }
}
