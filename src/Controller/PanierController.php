<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\PanierType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class PanierController extends AbstractController
{
    public function panier() {
        //$panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();
        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();

        return $this->render('panier/panier.html.twig', [
            'panier' => $panier
        ]);
    }

    public function supprProduit(Panier $panier, EntityManagerInterface $em) {
      $em->remove($panier);
      $em->flush();

      return $this->redirectToRoute("panier");
    }
}
