<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Dom\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit/produit', name: 'app_produit')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Produit();
        $form = $this->createForm(ProduitType::class,$product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $uploadsDirectory = $this->getParameter('product_directory');
                $filename = uniqid() . '.' . $image->guessExtension();
                $image->move($uploadsDirectory, $filename);
                $product->setImage($filename);
            }
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('produit_list');
        }

        return $this->render('produit/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/produit/Boutique', name: 'produit_Boutique')]
    public function Boutique(EntityManagerInterface $em): Response
    {
        $product = $em->getRepository(Produit::class)->findAll();
        return $this->render('produit/index.html.twig', [
            'products' => $product,
        ]);
    }

    #[Route('/produit/list', name: 'produit_list')]
    public function list(EntityManagerInterface $em) : Response {
        
        $product = $em->getRepository(Produit::class)->findAll();

        return $this->render('produit/list.html.twig',[
            'products' => $product,
        ]);
    }

    #[Route('/produit/Edit/{id}', name: 'produit_Edit')]
    public function Edit(Request $request,EntityManagerInterface $em,int $id): Response
    {
        $product = new Produit();
        $form = $this->createForm(ProduitType::class,$product);
        $form->handleRequest($request);
        $product = $em->getRepository(Produit::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé');
        }
        if($form->isSubmitted() && $form->isValid()){
            // Delete the old image file if it exists
            $oldImage = $product->getImage();
            if ($oldImage) {
                $uploadsDirectory = $this->getParameter('product_directory');
                $oldImagePath = $uploadsDirectory . '/' . $oldImage;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $form->get('image')->getData();

            if ($image) {
                $uploadsDirectory = $this->getParameter('product_directory');
                $filename = uniqid().".".$image->guessExtension();
                $image->move($uploadsDirectory,$filename);
                $product->setImage($filename);
            }
            $this->addFlash('success', 'Le produit a bien été édité.');
            $em->flush();
            return $this->redirectToRoute('product_detail', ['id' => $product->getId()]);
        }

       
        return $this->render('produit/edit.html.twig', [
          'form' => $form->createView(),
          'products' => $product
        ]);  
    }

    #[Route('/produit/delete/{id}', name: 'product_delete')]
    public  function delete(EntityManagerInterface $em, int $id): Response
    {
        $product = $em->getRepository(Produit::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        // Delete the image file if it exists
        $image = $product->getImage();
        if ($image) {
            $uploadsDirectory = $this->getParameter('product_directory');
            $imagePath = $uploadsDirectory . '/' . $image;
            if (file_exists($imagePath)) {
            unlink($imagePath);
            }
        }

        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'Le produit a bien été supprimé.');

        return $this->redirectToRoute('produit_list');
    }

    #[Route('/produit/detail/{id}', name: 'product_detail')]
    public function details(EntityManagerInterface $em, int $id):Response
    {
        $product = $em->getRepository(Produit::class)->find($id);
        $allproduct = $em->getRepository(Produit::class)->findAll();
        return $this->render('produit/detail.html.twig', [
          "product" => $product,
            "allproduct" => $allproduct,
        ]); 
    }

}
