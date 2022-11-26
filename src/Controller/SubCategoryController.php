<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubCategoryController extends AbstractController
{
    /**
     * @Route("/sub/category", name="app_sub_category")
     */
    public function index(): Response
    {
        return $this->render('sub_category/index.html.twig', [
            'controller_name' => 'SubCategoryController',
        ]);
    }
}
