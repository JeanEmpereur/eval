<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Entity\Panier;
use App\Form\ProduitType;
use App\Form\PanierType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class PanierController extends AbstractController
{
    public function panier() {
        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();

        return $this->render('panier/panier.html.twig', [
            'panier' => $panier
        ]);
    }

    public function addPanier(Produit $produit, Request $request, EntityManagerInterface $em){
      $panier = new Panier();
      $form = $this->createForm(PanierType::class, $panier);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $panier = $form->getData();
          $panier->setDateAjout(new \DateTime());
          $panier->setProduit($produit);
          $panier->setEtat(True);
          $em->persist($panier);
          $em->flush();

          return $this->redirectToRoute("panier");
      }

      return $this->render('panier/ajoutPanier.html.twig', [
          'p' => $produit,
          'form' => $form->createView(),
      ]);
    }
}
