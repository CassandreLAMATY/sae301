<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Notifications;
use App\Entity\NotifUsers;
use App\Repository\NotifUsersRepository;

class NotificationsController extends AbstractController
{
    #[Route('/notifications/delete/{id}', name: 'app_notifications_delete', methods: ["DELETE"])]
    public function delete(
        int $id, 
        EntityManagerInterface $entityManager, 
        NotifUsersRepository $notifUsersRepository
    ): Response
    {
        $user = $this->getUser();

        // select user's notification
        $nu = $notifUsersRepository->findByUserID($user->getUsrId());
        
        // select row that have both notification user id
        $notification = null;

        foreach ($nu as $row) {
            if ($row->getNuNot()->getNotId() == $id) {
                $notification = $row;
            }
        }

        if($notification) {
            $entityManager->remove($notification);
            $entityManager->flush();

            return new Response('deleted');
        }

        return new Response('not found');
    }
}
