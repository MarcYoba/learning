<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Inscription;
use App\Entity\Module;
use App\Entity\Paiement;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription/formation', name: 'app_inscription')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $inscription->setStatus('En cours');
            $inscription->setUser($user);
            $em->persist($inscription);
            $em->flush();

            return $this->redirectToRoute('inscription_view');
        }
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inscription/formation/view', name: 'inscription_view')]
    public function view(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $inscriptions = $em->getRepository(Inscription::class)->findBy(['user' => $user]);

        return $this->render('inscription/view.html.twig', [
            'inscriptions' => $inscriptions,
        ]);
    }

    #[Route('/inscription/formation/view/cours/{id}', name: 'inscription_view_cours')]
    public function viewCours(EntityManagerInterface $em, $id): Response
    {
        
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $paiement = $em->getRepository(Paiement::class)->findBy(['module' => $id]);
        if (empty($paiement)) {
            return $this->redirectToRoute('app_paiement');
        }
        $module = $em->getRepository(Cours::class)->findBy(['module' => $id]);

        if (!$module) {
            throw $this->createNotFoundException('Inscription not found');
        }
        $inscriptions = $em->getRepository(Inscription::class)->findBy(['user' => $user]);

        return $this->render('inscription/view_cours.html.twig', [
            'module' => $module,
            'inscriptions' => $inscriptions,
        ]);
    }
}
