<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    #[Route('/paiement/create', name: 'app_paiement')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $inscriptions = $em->getRepository(Inscription::class)->findBy(['user' => $user,'status' => 'En cours']);
       // $cours = $em->getRepository(Cours::class)->findBy(['user' => $user, 'status' => 'En cours']);
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        return $this->render('paiement/index.html.twig', [
            'inscriptions' => $inscriptions,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/paiement/mobile', name: 'paiement_mobile', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $paiement = new Paiement();
        $inscriptions = new Inscription();
        if ($request->isMethod('POST')){
            $donnepay = $request->request->all();
            
            $mobileinfo = array_pop($donnepay);
            $module = $em->getRepository(Module::class)->find($donnepay['module']);
    
            $paiement->setMontant($mobileinfo['montant']);
            $paiement->setOperateur($mobileinfo['operateur']);
            $paiement->setStatut('OK');
            $telephone = $mobileinfo['telephone'];
            $telephone = preg_replace('/[^0-9]/', '', $telephone);
            $paiement->setTelephone($telephone);
            $paiement->setNumerobancaire(0);
            $paiement->setNomtitulaire(0);
            $inscriptions->setStatus('Ok');
            $paiement->setModule($module);
            $paiement->setUser($this->getUser());
            $paiement->setDateExpiration(new \DateTimeImmutable('0000-00-00 00:00:00'));
            $paiement->setCreateAt(new \DateTimeImmutable());
            $paiement->setCVV(0);
            $em->persist($paiement);
            $em->flush();
            $inscription = $em->getRepository(Inscription::class)->findOneBy([
                'user' => $this->getUser(),
                'module' => $module,
                'status' => 'En cours'
            ]);

            if ($inscription) {
                $inscription->setStatus('Ok');
                $em->persist($inscription);
            }
        
            return $this->redirectToRoute('inscription_view');
        }

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $inscriptions = $em->getRepository(Inscription::class)->findBy(['user' => $user,'status' => 'En cours']);
       
        
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);
        return $this->render('paiement/index.html.twig', [
           'inscriptions' => $inscriptions,
            'form' => $form->createView(), 
        ]);
    }
}
