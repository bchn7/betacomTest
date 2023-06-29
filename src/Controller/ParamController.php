<?php


namespace App\Controller;

use App\Entity\Param;
use App\Form\ParamFormType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ParamController extends AbstractController
{
    #[Route('/param', name: 'param')]
    public function show(Environment $twig, Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
    {
        $param = new Param;

        $form = $this->createForm(ParamFormType::class, $param);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($param);
            $entityManager->flush();

            $logger->info('Param id: {id} added to db', [
                'id' => $param->getId(),
            ]);
            return new Response('Param number' . $param->getId() . ' created..');
        }

        return new Response($twig->render('param.html.twig', [
            'param_form' => $form->createView()
        ]));
    }
}