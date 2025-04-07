<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    #[Route('/module/create', name: 'app_module')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form->get('createdAt')->getData();
            $code = $form->get('code')->getData();
            $validation = $entityManager->getRepository(Module::class)->findOneBy(['code' => $code]);
            if ($validation) {
                $this->addFlash('error', 'Ce code de module existe déjà.');
                return $this->redirectToRoute('app_module');
            }else{
                $module->setVideo(0);
            }
            $module->setCreatedAt(new \DateTimeImmutable($date->format('Y-m-d H:i:s')));
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('module_list');
        }
        return $this->render('module/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/module/list', name: 'module_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        
        $modules = $entityManager->getRepository(Module::class)->findAll();
        return $this->render('module/list.html.twig', [
            'modules' => $modules,
        ]);
    }
}
