<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ProduitController extends AbstractController
{
    public function produits() {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        return $this->render('Home.html.twig', [
            'controller_name' => 'HomeController',
            'produits' => $produits
        ]);
    }

    public function addProduit(Request $request, EntityManagerInterface $em) {

      $produit = new Produit();
      $form = $this->createForm(ProduitType::class, $produit);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

            $produit = $form->getData();
            //$note->setMatiere($matiere);

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute("home");
        }

      return $this->render('produit/ajoutProduit.html.twig', [
          'form' => $form->createView(),
          'produit' => $produit
      ]);
    }

    public function produit(Produit $produit, Request $request, EntityManagerInterface $em){

        // $panier = new Panier();
        // $form = $this->createForm(PanierType::class, $panier);
        // $form->handleRequest($request);
        //
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $produit = $form->getData();
        //     $produit->setCreateAt(new \DateTime());
        //     $em->persist($produit);
        //     $em->flush();
        //
        //     return $this->redirectToRoute("");
        // }


        return $this->render('produit/produit.html.twig', [
            'p' => $produit,
            //'form' => $form->createView(),
        ]);
    }
}
