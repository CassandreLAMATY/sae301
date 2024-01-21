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
use App\Repository\SubjectsRepository;
use App\Repository\CardsRepository;

use App\Entity\Notifications;
use App\Entity\NotifUsers;
use App\Entity\UsersCards;
use App\Entity\Users;
use App\Entity\Cards;

use App\Form\CardsType;

use App\Controller\NotificationsController;
use App\Entity\Subjects;

class CardsController extends AbstractController
{
    #[Route('/cards/createForm', name: 'app_cards_createForm')]
    public function _createForm(): Response
    {
        $card = new Cards();

        $form = $this->createForm(CardsType::class, $card, [
            'action' => $this->generateUrl('app_cards_createForm'),
            'method' => 'POST',
            'attr' => ['id' => 'create-cards-form'],
        ]);

        return $this->render('cards/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cards/create', name: 'app_cards_create', methods: ["POST"])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
        TypesRepository $typesRepository,
        NotificationsController $notificationsController,
        SubjectsRepository $subjectsRepository,
        CardsRepository $cardsRepository
    ): Response
    {
        $form = $this->createForm(CardsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $request->request->all();
            $cardData = $formData['cards'];
            $type = $typesRepository->find($cardData['crd_typ']);
            $user = $usersRepository->find($this->getUser());
            
            $subject = $cardData['crd_sbj'] ? $subjectsRepository->find($cardData['crd_sbj']) : null;

            $from = $cardData['crd_from'] ? new \DateTime($cardData['crd_from']) : null;
            $to = new \DateTime($cardData['crd_to']);

            // CARD
            $card = new Cards();
            $card->setCrdCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
            $card->setCrdTyp($type);
            $card->setCrdTitle($cardData['crd_title']);
            $cardData['crd_desc'] ? $card->setCrdDesc($cardData['crd_desc']) : '';
            $subject ? $card->setCrdSbj($subject) : '';
            $from ? $card->setCrdFrom($from) : '';
            $card->setCrdTo($to);
            $card->setIsValidated(false);

            $entityManager->persist($card);

            // Link card to user
            $userTp = $user->getUsrTp();
            if ( $cardData['crd_grp'] == 0 ) {
                $users = $usersRepository->findByTp($userTp);
                foreach ($users as $user) {
                    $userCard = new UsersCards();

                    $userCard->setUcCrd($card);
                    $userCard->setUcUsr($user);
                    $userCard->setUcDone(false);

                    $entityManager->persist($userCard);
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
                        $userCard = new UsersCards();

                        $userCard->setUcCrd($card);
                        $userCard->setUcUsr($user);
                        $userCard->setUcDone(false);

                        $entityManager->persist($userCard);
                    }
                }
            }

            $entityManager->flush();

            $createdCard = $cardsRepository->findLastCard();

            // Sending notification
            $notificationsController->sendNotification( $request, $entityManager, $usersRepository, $typesRepository, $cardsRepository, $createdCard );
        }


    }
}