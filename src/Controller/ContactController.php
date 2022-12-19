<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    /**
     * @Route("/contact/add", name="app_add_contact", methods="POST")
     */
    public function addContact(EntityManagerInterface $em, Request $request):Response
    {
        $contact = new Contact();
        $contact->setFirstName($request->get("fname"))
                ->setLastName($request->get("lname"))
                ->setEmail($request->get("email"))
                ->setSubject($request->get('subject'))
                ->setMessage($request->get('message'));
        $em->persist($contact);
        $em->flush();
        $this->addFlash('success', 'Thnak You, we\'ll contact you bak as soon as possible .');
        return $this->redirect("app_home");
    }
}
