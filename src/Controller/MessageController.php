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
     * @Route("/messages", name="app_message")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $messages = $em->getRepository(Message::class)->findBy(["receiver"=>$this->getUser()]);
        return $this->render('dashboard/messages.html.twig', [
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

    /**
     * @Route("/message/remove/{id}", name="app_delete_message")
     */
    public function deleteMessage(EntityManagerInterface $em, Request $request, $id):Response
    {
        $message = $em->getRepository(Message::class)->find($id);
        $em->remove($message);
        $em->flush();
        $this->addFlash('success', 'Message Removed Successfully');
        return $this->redirectToRoute('app_message');
    }

    /**
     * @Route("/conversation", name="app_convrsation")
     */
    public function conversation(EntityManagerInterface $em, Request $request):Response
    {
        $receiver = $this->getUser();
        $sender = $request->get('sender');
        
        return $this->redirectToRoute('app_message');
    }
}
