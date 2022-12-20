<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Category::class)->findAll();
        $movies = $em->getRepository(Movie::class)->findAll();

        //trending (6)

        //popular(6)
        //recentlt added(6)
        //top views
        //new comments
        
        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'categories'=>$categories
        ]);
    }

    //by category
            //top views
            //new comment


}
