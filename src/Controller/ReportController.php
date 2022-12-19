<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Report;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    /**
     * @Route("/report", name="app_report")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $reports = $em->getRepository(Report::class)->findAll();
        return $this->render('report/index.html.twig', [
            'reports' => $reports,
        ]);
    }

    /**
     * @Route("/add/report", name="app_add_report", methods="POST")
     */
    public function report(Request $request, EntityManagerInterface $em):Response
    {
        $report = new Report();
        $report->setMovie($em->getReference(Movie::class, $request->get('movie')))
                ->setUser($this->getUser())
                ->setContent($request->get('content'));
        $em->persist($report);
        $em->flush();
        $this->addFlash('success','Thank you we have been received your report we will check it as soon as possible');
        return $this->redirectToRoute('app_home');
    }
}
