<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Movie;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{
    /**
     * @Route("/comments", name="app_comments")
     */
    public function index(): Response
    {
        return $this->render('comments/index.html.twig', [
            'controller_name' => 'CommentsController',
        ]);
    }

    /**
     * @Route("/comments/add", name="app_add_comment", methods="POST")
     */
    public function addComment(EntityManagerInterface $em, Request $request):Response
    {
        try{
            $movie = $em->getRepository(Movie::class)->find($request->get('movie'));
        $comment = new Comment();
        $comment->setBody($request->get('comment'))
                ->setLikes(0)
                ->setDislikes(0)
                ->setUser($em->getReference(User::class, $this->getUser()->getId()))
                ->setCommentedAt(new DateTime())
                ->setMovie($movie);
        $em->persist($comment);
        $em->flush();
        $this->addFlash('success', 'Comment Added');
        return $this->redirectToRoute('app_movie_details', ['id'=>$movie->getId()]);
        }catch(\Exception $e){
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_dashboard_movies');
        } 
    }

    /**
     * @Route("/comment/remove", name="app_remove_comment", methods="POST")
     */
    public function removeComment(EntityManagerInterface $em, Request $request):Response
    {
        try{
            $comment = $em->getRepository(Comment::class)->find($request->get('comment'));
        $em->remove($comment);
        $em->flush();
        $this->addFlash('success', 'comment Removed !');
        return $this->redirectToRoute('app_comments');
        }catch(\Exception $e){
            $this->addFlash('error', 'an error occured please try again');
            return $this->redirectToRoute('app_comments');
        } 
        
    }
}
