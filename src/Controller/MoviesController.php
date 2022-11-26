<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    /**
     * @Route("/movies", name="app_movies")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $movies = $em->getRepository(Movie::class)->findBy(['user'=>$this->getUser()]);
        return $this->render('movies/index.html.twig', [
            'movies' => $movies,
        ]);
    }


    /**
     * @Route("/movie/new", name="app_add_movie", methods="POST")
     */
    public function addMovie(EntityManagerInterface $em, Request $request):Response
    {
        try{
            $movie = new Movie();
            $movie->setTitle($request->get(''))
                ->setImage($request->get(''))
                ->setDescription($request->get(''))
                ->setDuration($request->get(''))
                ->setReleasedAt($request->get(''))
                ->setLink($request->get(''))
                ->setCategory($request->get(''))
                ->setSubCategory($request->get(''))
                ->setUser($request->get(''));
            $em->persist($movie);
            $em->flush();
            $this->addFlash('success', 'Movie Added successfully');
            return $this->redirectToRoute('app_movies');
        }catch(\Exception $e){
            $this->addFlash('error', 'an error occured please try again !');
            return $this->redirectToRoute('app_movies');
        }
    }

    /**
     * @Route("/movie/update", name="app_update_movie", methods="POST")
     */
    public function updateMovie(EntityManagerInterface $em, Request $request):Response
    {
        try{

            $this->addFlash('success', 'Movie updated successfully');
            return $this->redirectToRoute('app_movies');
        }catch(\Exception $e){
            $this->addFlash('error', 'an error occured please try again !');
            return $this->redirectToRoute('app_movies');
        }
    }

    public function removeMovie(EntityManagerInterface $em, Request $request):Response
    {
        try{

            $this->addFlash('success', 'Movie removed successfully');
            return $this->redirectToRoute('app_movies');
        }catch(\Exception $e){
            $this->addFlash('error', 'an error occured please try again !');
            return $this->redirectToRoute('app_movies');
        }
    }
}
