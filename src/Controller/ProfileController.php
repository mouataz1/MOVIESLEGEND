<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /**
     * @Route("/profile/update/info-generale", name="app_profile_update_generale", methods="POST")
     */
    public function updateGeneraleInfo(EntityManagerInterface $em, Request $request):Response
    {
        return $this->redirectToRoute('app_profile');
    }

    /**
     * @Route("/profile/update/password", name="app_profile_update_password", methods="POST")
     */
    public function updatePassword(EntityManagerInterface $em, Request $request):Response
    {
        return $this->redirectToRoute('app_profile');
    }

    /**
     * @Route("/profile/update/avatar", name="app_profile_update_avatar", methods="POST")
     */
    public function updateAvatar(EntityManagerInterface $em, Request $request):Response
    {
        return $this->redirectToRoute('app_profile');
    }
}
