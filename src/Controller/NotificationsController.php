<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\NotifUsersRepository;
use App\Repository\UsersRepository;
use App\Repository\TypesRepository;

use App\Entity\Notifications;
use App\Entity\NotifUsers;
use App\Entity\Users;
use App\Repository\CardsRepository;

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

    #[Route('/notifications/deleteAll', name: 'app_notifications_deleteAll', methods: ["DELETE"])]
    public function deleteAll(
        EntityManagerInterface $entityManager, 
        NotifUsersRepository $notifUsersRepository
    ): Response
    {
        $user = $this->getUser();

        // select user's notification
        $nu = $notifUsersRepository->findByUserID($user->getUsrId());

        foreach ($nu as $row) {
            $entityManager->remove($row);
        }

        $entityManager->flush();

        return new Response('deleted');
    }

    #[Route('/notifications/markAsRead/{id}', name: 'app_notifications_read', methods: ["POST"])]
    public function markAsRead(
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
            $notification->setIsNuSeen(true);
            $entityManager->persist($notification);
            $entityManager->flush();

            return new Response('marked');
        }

        return new Response('not found');
    }

    #[Route('/notifications/markAllAsRead', name: 'app_notifications_readAll', methods: ["POST"])]
    public function markAllAsRead(
        EntityManagerInterface $entityManager, 
        NotifUsersRepository $notifUsersRepository,
    ): Response
    {
        $user = $this->getUser();

        // select user's notification
        $nu = $notifUsersRepository->findByUserID($user->getUsrId());

        foreach ($nu as $row) {
            if ($row->isNuSeen() == false) {
                $row->setIsNuSeen(true);
                $entityManager->persist($row);
            }
        }

        $entityManager->flush();

        return new Response('marked');
    }

    #[Route('/notifications/create', name: 'app_notifications_create', methods: ["POST"])]
    public function sendNotification(
        Request $request,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
        TypesRepository $typesRepository,
        CardsRepository $cardsRepository,
        $createdCard,
        $cardId
    ): Response {
        $notification = new Notifications();

        $formData = $request->request->all();
        $cardData = $formData['cards'];
        $type = $typesRepository->find($cardData['crd_typ']);
        $user = $usersRepository->find($this->getUser());

        // Create notification
        $notification->setNotType($type);
        $notification->setNotTitle($type->getTypName() . " - " . $cardData['crd_title']);
        $notification->setNotCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));

        $entityManager->persist($notification);

        // Link notification to user
        $userTp = $user->getUsrTp();
        if ( $cardData['crd_grp'] == 0 ) {
            $users = $usersRepository->findByTp($userTp);
            foreach ($users as $user) {
                $notifUser = new NotifUsers();

                $notifUser->setNuNot($notification);
                $notifUser->setNuUsr($user);
                $notifUser->setIsNuSeen(false);

                $card = $cardsRepository->find($cardId);
                $notifUser->setNuCrd($card);

                $entityManager->persist($notifUser);
            }
        } else {
            $map = [
                "A" => ["A", "B"],
                "B" => ["A", "B"],
                "C" => ["C", "D"],
                "D" => ["C", "D"],
                "E" => ["E", "F"],
                "F" => ["E", "F"],
                "G" => ["G", "H"],
                "H" => ["G", "H"],
            ];
            
            $td = $map[$userTp] ?? ["A", "B", "C", "D", "E", "F", "G", "H"];
            foreach($td as $tp) {
                $users = $usersRepository->findByTp($tp);
                foreach ($users as $user) {
                    $notifUser = new NotifUsers();

                    $notifUser->setNuNot($notification);
                    $notifUser->setNuUsr($user);
                    $notifUser->setIsNuSeen(false);

                    $notifUser->setNuCrd($createdCard);

                    $entityManager->persist($notifUser);
                }
            }
        }

        $entityManager->flush();

        header('Location: /');
        exit;
    }
}
