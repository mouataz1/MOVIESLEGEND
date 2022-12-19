<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="app_message")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $messages = $em->getRepository(Message::class)->findBy(["user"=>$this->getUser()]);
        return $this->render('message/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/message/send", name="app_send_message", methods="POST")
     */
    public function sendMessage(EntityManagerInterface $em, Request $request):Response
    {
        $message = new Message();
        $message->setSender($em->getReference(User::class, $this->getUser))
                ->setReceiver($em->getReference(User::class, $this->getUser))
                ->setContent($request->get("content"));
        $em->persist($message);
        $em->flush();
        $this->addFlash('success', 'message sent !');
        return $this->redirectToRoute('app_message');
    }
}
