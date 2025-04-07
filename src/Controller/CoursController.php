<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    #[Route('/cours/create', name: 'app_cours')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
            $video = $form->get('Video')->getData();
            if($video) {
                $newFilename = uniqid().'.'.$video->guessExtension();
                $video->move($this->getParameter('videos_directory'), $newFilename);
                $cours->setVideo($newFilename);
            }

            $em->persist($cours);
            $em->flush();

            return $this->redirectToRoute('cours_list');
        }else if($form->isSubmitted() && !$form->isValid()) {
           dd($form->getErrors(true, false));
        }

        return $this->render('cours/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cours/list', name: 'cours_list')]
    public function show(EntityManagerInterface $em): Response
    {
        $cours = $em->getRepository(Cours::class)->findAll();
        return $this->render('cours/show.html.twig', [
            'cours' => $cours,
        ]);
    }
}
