<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Progress;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgressController extends AbstractController
{
    /**
     * @Route("/progress/create", name= "app_progress" , methods={"POST"})]
     */
    public function index(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $progress = new Progress();

        if(isset($data["video_id"]) && isset($data["progresse"]) && isset($data["module_id"]))
        {
            $module = $em->getRepository(Cours::class)->findBy(['module' => $data["module_id"]]);
            $idcour = $data["video_id"];
            $idcour +=1;
            $user = $this->getUser();
            $cours = $em->getRepository(Cours::class)->find($idcour);
            $progress = $em->getRepository(Progress::class)->findOneBy([
                "user" => $user,
                "cours" => $cours
            ] );

            if ($progress) {
                if ($progress->getPourcentage()<100) {
                    if ($data["progresse"]>$progress->getPourcentage()) {
                        $progress->setPourcentage($data["progresse"]);
                        $em->flush();
                    } 
                } 
                
                return new JsonResponse([
                    'status' => 'success',
                    'data' => $data,
                    'cours' => "Trouver",
                ]);
            }else{

                $progress = new Progress();
                $progress->setCours($cours);
                $progress->setUser($user);
                $progress->setPourcentage($data["progresse"]);

                $em->persist($progress);
                $em->flush();

                return new JsonResponse([
                        'status' => 'success',
                        'data' => $data,
                        'cours' => " Non trouver, cours creer",

                    ]);
            }

        }
        return new JsonResponse([
            'status' => 'success',
            'data' => $data

        ]);
    }
}
