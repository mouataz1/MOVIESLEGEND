<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $trending = $em->getRepository(Movie::class)->getTrending();
        $random = $em->getRepository(Movie::class)->random();
       
        
        
        //new comments
        
        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'categories'=>$categories,
            'trending'=>$trending,
            'random'=>$random
        ]);
    }

    /**
     * @Route("/movieslegends/category/{id}", name="movies_by_cat")
     */
    public function moviesByCategories(Request $request, EntityManagerInterface $em, $id):Response
    {
        $categories = $em->getRepository(Category::class)->findAll();
        $trending = $em->getRepository(Movie::class)->getTrending();
        $random = $em->getRepository(Movie::class)->random();
        $category = $em->getRepository(Category::class)->find($id);
        $movies = $em->getRepository(Movie::class)->findBy(['category'=>$category]);
        //dd($movies);
        return $this->render('home/moviesByCategories.html.twig', [
            'movies' => $movies,
            'categories'=>$categories,
            'trending'=>$trending,
            'random'=>$random,
            'category'=>$category
        ]);
    }

    /**
     * @Route("/movieslegend/movie/{id}", name="home_movie_detail")
     */
    public function movieDetail(EntityManagerInterface $em, Request $request, $id):Response
    {
        $categories = $em->getRepository(Category::class)->findAll();
        $movie = $em->getRepository(Movie::class)->find($id);
        $movies = $em->getRepository(Movie::class)->findAll();
        return $this->render('home/movieDetails.html.twig',[
            'movie'=>$movie,
            'movies'=>$movies,
            'categories'=>$categories
        ]);
    }


}
