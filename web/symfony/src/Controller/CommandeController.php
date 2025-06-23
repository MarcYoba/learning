<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande/add', name: 'app_commande')]
    public function index(EntityManagerInterface $em): Response
    {
        $product = $em->getRepository(Produit::class)->findAll();
        $panier = $em->getRepository(Panier::class)->findBy(["user"=>$this->getUser()]);
        
        return $this->render('commande/index.html.twig', [
            'products' => $product,
            'panier' => $panier,
        ]);
    }
}
