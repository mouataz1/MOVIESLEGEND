<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\SubCategory;
use App\Service\UploaderService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    /**
     * @Route("/dashboard/movies", name="app_dashboard_movies")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $movies = $em->getRepository(Movie::class)->findBy(['user'=>$this->getUser()]);
        $allmovies = $em->getRepository(Movie::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('dashboard/movies.html.twig', [
            'movies' => $movies,
            'categories'=>$categories,
            'allmovies'=>$allmovies
        ]);
    }


    /**
     * @Route("/movie/new", name="app_add_movie", methods="POST")
     */
    public function addMovie(EntityManagerInterface $em, Request $request, UploaderService $uploader):Response
    {
        try{
            $movie = new Movie();
            $movie->setTitle($request->get('title'))
                ->setImage($uploader->upload($request->files->get('image')))
                ->setDescription($request->get('description'))
                ->setDuration($request->get('duration'))
                ->setReleasedAt(new DateTime($request->get('releasedAt')) )
                ->setLink($request->get('link'))
                ->setCategory($em->getReference(Category::class, $request->get('category')))
                //->setSubCategory($em->getReference(SubCategory::class, $request->get('category')))
                ->setUser($this->getUser());
            $em->persist($movie);
            $em->flush();
            $this->addFlash('success', 'Movie Added successfully');
            return $this->redirectToRoute('app_dashboard_movies');
        }catch(\Exception $e){
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_dashboard_movies');
        }
    }

    /**
     * @Route("/movie/update", name="app_update_movie", methods="POST")
     */
    public function updateMovie(EntityManagerInterface $em, Request $request, UploaderService $uploader):Response
    {
        try{
            $movie = $em->getRepository(Movie::class)->find($request->get('movie'));
            $movie->setTitle($request->get('title'))
                ->setImage($uploader->upload($request->files->get('image')))
                ->setDescription($request->get('description'))
                ->setDuration($request->get('duration'))
                ->setReleasedAt(new DateTime($request->get('releasedAt')))
                ->setLink($request->get('link'))
                ->setCategory($em->getReference(Category::class, $request->get('category')))
                //->setSubCategory($em->getReference(SubCategory::class, $request->get('category')))
                ->setUser($this->getUser());
            $em->persist($movie);
            $em->flush();
            $this->addFlash('success', 'Movie updated successfully');
            return $this->redirectToRoute('app_dashboard_movies');
        }catch(\Exception $e){
            $this->addFlash('error', 'an error occured please try again !');
            return $this->redirectToRoute('app_dashboard_movies');
        }
    }

    /**
     * @Route("/movie/delete/{id}", name="app_delete_movie")
     */
    public function removeMovie(EntityManagerInterface $em, Request $request, $id):Response
    {
        try{
            $movie = $em->getRepository(Movie::class)->find($id);
            $em->remove($movie);
            $em->flush();
            $this->addFlash('success', 'Movie removed successfully');
            return $this->redirectToRoute('app_dashboard_movies');
        }catch(\Exception $e){
            $this->addFlash('error', 'an error occured please try again !');
            return $this->redirectToRoute('app_dashboard_movies');
        }
    }

    /**
     * @Route("/movie/{id}", name="app_movie_details")
     */
    public function movieDetails(Request $request, EntityManagerInterface $em, $id):Response
    {
        $movie = $em->getRepository(Movie::class)->find($id);
        return $this->render('dashboard/movieDetails.html.twig', [
            'movie' => $movie
        ]);

    }
}
