<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier/add/{id}', name: 'app_panier')]
    public function index(EntityManagerInterface $em,int $id): Response
    {
        $panier = new Panier();
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $produit = $em->getRepository(Produit::class)->findOneBy(["id" => $id]);
        if($produit){
            $panier->setProduit($produit);
            $panier->setUser($this->getUser());
            $panier->setCreatAt(new \DateTime());

            $em->persist($panier);
            $em->flush();
        }
        return $this->redirectToRoute("produit_Boutique");
    }
    
    #[Route('/panier/delete/{id}', name: 'panier_delete')]
    public function delete(EntityManagerInterface $em, int $id): Response
    {
        $panier = $em->getRepository(Panier::class)->findOneBy([
            'id' => $id,
            'user' => $this->getUser()
        ]);

        if ($panier) {
            $em->remove($panier);
            $em->flush();
        }

        return $this->redirectToRoute("produit_Boutique");
    }

    #[Route('/panier/view', name: 'panier_view')]
    public function view(EntityManagerInterface $em) : Response {

        $product = $em->getRepository(Produit::class)->findAll();
        $panier = $em->getRepository(Panier::class)->findBy(["user"=>$this->getUser()]);
        return $this->render('panier/view.html.twig',[
            'products' => $product,
            'panier' => $panier,
        ]);
    }
}