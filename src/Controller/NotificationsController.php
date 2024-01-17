<?php

namespace App\Controller;

use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationsController extends AbstractController
{
    #[Route('/notifications/delete/{id}', name: 'app_notifications')]
    public function deleteNotification(int $id): Response
    {
        private $entityManager;
        
        public function __construct(Type $var = null) {
            $this->var = $var;
        }

        if (!$notification) {
            throw $this->createNotFoundException('Notification not found');
        }

        $entityManager->remove($notification);
        $entityManager->flush();

        return new Response("Notification deleted successfully");
    }
}
