<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikesController extends AbstractController
{
    /**
     * @Route("/likes", name="app_likes")
     */
    public function index(): Response
    {
        return $this->render('likes/index.html.twig', [
            'controller_name' => 'LikesController',
        ]);
    }
}
