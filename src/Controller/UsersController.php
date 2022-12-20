<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="app_users")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();
       /*  $usermovies = [];
        foreach($users as $u){
            $usermovies = $em->getRepository(Movie::class)->findByUser($u);
        } */
        
        return $this->render('dashboard/users.html.twig', [
            'users' => $users,
        ]);
    }


    /**
     * @Route("/user/enable", name="app_enable_user", methods="POST")
     */
    public function enableUser(EntityManagerInterface $em, Request $request):Response
    {
        $user = $em->getRepository(User::class)->find($request->get("userid"));
        $user->setIsEnabled(1);
        $em->persist($user);
        $em->flush();
        $this->addFlash('success', 'user enabled successfully');
        return $this->redirectToRoute('app_users');

    }

    
    /**
     * @Route("/user/disable", name="app_disable_user", methods="POST")
     */
    public function disableUser(EntityManagerInterface $em, Request $request):Response
    {
        $user = $em->getRepository(User::class)->find($request->get("userid"));
        $user->setIsEnabled(0);
        $em->persist($user);
        $em->flush();
        $this->addFlash('success', 'user disabled successfully');
        return $this->redirectToRoute('app_users');

    }
}
