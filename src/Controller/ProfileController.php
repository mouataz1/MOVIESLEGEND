<?php

namespace App\Controller;

use App\Service\UploaderService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('dashboard/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profile/update/info-generale", name="app_profile_update_generale", methods="POST")
     */
    public function updateGeneraleInfo(EntityManagerInterface $em, Request $request):Response
    {
        $user= $this->getUser();
        $user->setUsername($request->get('username'))
            ->setEmail($request->get('email'))
            ->setGender($request->get('gender'))
            ->setBirthday(new DateTime($request->get('birthday')));
        $em->persist($user);
        $em->flush();
        $this->addFlash('success', 'information updated succesfully !');
        return $this->redirectToRoute('app_profile');
    }

    /**
     * @Route("/profile/update/password", name="app_profile_update_password", methods="POST")
     */
    public function updatePassword(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $hasher):Response
    {
        $user = $this->getUser();
        $new = $request->get('new');
        $confirm = $request->get('confirm');
        if($new === $confirm){
            $user->setPassword($hasher->hashPassword($user, $new));
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'password updated succesfully !');
            return $this->redirectToRoute('app_profile');
        }else{
            $this->addFlash('error', 'password and confirmation does not match !');
            return $this->redirectToRoute('app_profile');
        }
        
    }

    /**
     * @Route("/profile/update/avatar", name="app_profile_update_avatar", methods="POST")
     */
    public function updateAvatar(EntityManagerInterface $em, Request $request, UploaderService $uploader):Response
    {
        $user = $this->getUser();
        $user->setImage($uploader->upload($request->files->get('image')));
        $em->persist($user);
        $em->flush();
        $this->addFlash('success', 'image updated successfully');
        return $this->redirectToRoute('app_profile');
    }
}
