<?php


namespace App\Controller;

use App\Entity\Exam;
use App\Form\ExamFormType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ExamController extends AbstractController
{
    #[Route('/exam', name: 'exam')]
    public function show(Environment $twig, Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
    {
        $exam = new Exam;

        $form = $this->createForm(ExamFormType::class, $exam);
        
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($exam);
            $entityManager->flush();

            $logger->info('Exam id: {id} added to db', [
                'id' => $exam->getId(),
            ]);
            return new Response('Exam number ' . $exam->getId() . ' created..');
        }

        return new Response($twig->render('exam.html.twig', [
            'exam_form' => $form->createView()
        ]));

    }

}