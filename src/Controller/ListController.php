<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Param;
use App\Entity\Exam;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ListController extends AbstractController {

    #[Route('/', name: 'index')]
    public function showParams(EntityManagerInterface $entityManagerInterface, LoggerInterface $logger): Response
    {
        $param = $entityManagerInterface->getRepository(Param::class)->findAll();

        if(!$param) {
            $logger->error('No params found to show in Table at /');
            throw $this->createNotFoundException(
                'No Params found'
            );
        }

        $exam = $entityManagerInterface->getRepository(Exam::class)->findAll();

        if(!$exam) {
            $logger->error('No exams found to show in Table at /');
            throw $this->createNotFoundException(
                'No Exams found'
            );
        }

        return $this->render('index.html.twig', ['param' => $param, 'exam' => $exam]);
    }

    #[Route('/exam/{id}')]
    public function showById(EntityManagerInterface $entityManagerInterface, int $id, LoggerInterface $logger): Response
    {
        $param = $entityManagerInterface->getRepository(Param::class)->findBy(
            ['exam_id' => $id]
        );

        if(!$param) {
            $logger->error('No params found to show in Table at /exam/id');
            throw $this->createNotFoundException(
                'No Params found'
            );
        }


        return $this->render('examById.html.twig', ['param' => $param, 'id' => $id]);
    }

}

