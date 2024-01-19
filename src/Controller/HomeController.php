<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CardsRepository;
use App\Repository\SubjectsRepository;
use App\Repository\TypesRepository;
use App\Repository\NotificationsRepository;
use App\Repository\UsersRepository;
use App\Repository\NotifUsersRepository;
use Symfony\Bundle\SecurityBundle\Security;

class HomeController extends AbstractController
{
    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_home')]
    public function index(
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository,
        NotificationsRepository $notificationsRepository,
        NotifUsersRepository $notifUserRepository
    ): Response {
        // -------------------------- NOTIFICATIONS --------------------------//

        // Selecting the user
        $user = $this->getUser();

        // Selecting every notification id by user id
        $notifications = $notifUserRepository->findByUserID($user->getUsrId());
        $notifSeen = [];
        $notifSeen = [];

        // Creating an array with every notification id
        $shouldNotify = false;
        foreach ($notifications as $notif) {
            if ($notif->isNuSeen()) {
                $notifSeen[] = $notif;
            } else {
                $notifNotSeen[] = $notif;
            }
        }

        // ----------------------- END NOTIFICATIONS ------------------------ //

        $cards = $cardsRepository->findAll();
        $cardData = [];

        foreach ($cards as $card) {
            $timeEnd = $card->getCrdTo();

            if ($card->getCrdFrom()) {
                $timeEnd = $card->getCrdFrom();
            }

            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            //if timeEnd is before now, skip this card
            if ($timeEnd < $now) {
                continue;
            }

            $typeId = $card->getCrdTypId();
            $type = $typesRepository->find($typeId);

            $subjectId = $card->getCrdSbjId();
            $subject = $subjectsRepository->find($subjectId);

            $timeleft = $now->diff($timeEnd);
            $dayLeft = $timeleft->format('%a');
            $dayLeft = (int)$dayLeft;

            $timeColor = 'var(--grey)';

            if ($dayLeft < 8) {
                $timeColor = 'var(--accent-orange)';
            }

            if ($dayLeft < 3) {
                $timeColor = 'var(--accent-red)';
            }

            if ($type !== null) {
                $cardData[] = [
                    'card' => $card,
                    'typeName' => $type->getTypName(),
                    'typeColor' => $type->getTypColor(),
                    'subjectRef' => $subject->getSbjRef(),
                    'subjectName' => $subject->getSbjName(),
                    'timeColor' => $timeColor,
                ];
            }
        }

        usort($cardData, function ($a, $b) {
            return $a['card']->getCrdTo() <=> $b['card']->getCrdTo();
        });

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,
            $user = $this->getUser();
            $username = $user->getUsrPseudo();
            $lastname = $user->getUsrName();
            $firstname = $user->getUsrFirstname();
            $email = $user->getUsrMail();

            return $this->render('home/index.html.twig', [
                'username' => $username,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'email' => $email,
                'cardData' => $cardData,

                'detailsCard' => null,

                'notifSeen' => $notifSeen,
                'notifNotSeen' => $notifNotSeen,
                'shouldNotify' => $shouldNotify,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/list', name: 'app_list')]
    public function list(
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository,
        NotificationsRepository $notificationsRepository,
        NotifUsersRepository $notifUserRepository
    ): Response {
        // -------------------------- NOTIFICATIONS --------------------------//

        // Selecting the user
        $user = $this->getUser();

        // Selecting every notification id by user id
        $notifications = $notifUserRepository->findByUserID($user->getUsrId());
        $notifSeen = [];
        $notifSeen = [];

        // Creating an array with every notification id
        $shouldNotify = false;
        foreach ($notifications as $notif) {
            if ($notif->isNuSeen()) {
                $notifSeen[] = $notif;
            } else {
                $notifNotSeen[] = $notif;
            }
        }

        // ----------------------- END NOTIFICATIONS ------------------------ //

        $cards = $cardsRepository->findAll();
        $cardData = [];

        foreach ($cards as $card) {

            if($card->getCrdFrom()){
                $formatedDateFrom = $card->getCrdFrom()->format('Y-m-d');
            }else{
                $formatedDateFrom = null;
            }

            $formatedDateTo = $card->getCrdTo()->format('Y-m-d');

            $timeEnd = $card->getCrdTo();

            if ($card->getCrdFrom()) {
                $timeEnd = $card->getCrdFrom();
            }

            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            $typeId = $card->getCrdTypId();
            $type = $typesRepository->find($typeId);

            $subjectId = $card->getCrdSbjId();
            $subject = $subjectsRepository->find($subjectId);

            $timeleft = $now->diff($timeEnd);
            $dayLeft = $timeleft->format('%a');
            $dayLeft = (int)$dayLeft;

            $timeColor = 'var(--grey)';

            if ($dayLeft < 8) {
                $timeColor = 'var(--accent-orange)';
            }

            if ($dayLeft < 3) {
                $timeColor = 'var(--accent-red)';
            }

            if ($type !== null) {
                $cardData[] = [
                    'card' => $card,
                    'typeName' => $type->getTypName(),
                    'typeColor' => $type->getTypColor(),
                    'subjectRef' => $subject->getSbjRef(),
                    'subjectName' => $subject->getSbjName(),
                    'timeColor' => $timeColor,
                    'startTime' => $formatedDateFrom,
                    'endTime' => $formatedDateTo,
                ];
            }
        }

        $weekList = $this->generateWeekList();

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,
            $user = $this->getUser();
            $username = $user->getUsrPseudo();
            $lastname = $user->getUsrName();
            $firstname = $user->getUsrFirstname();
            $email = $user->getUsrMail();

            return $this->render('home/list.html.twig', [
                'username' => $username,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'email' => $email,
                'cardData' => $cardData,

                'detailsCard' => null,

                'notifSeen' => $notifSeen,
                'notifNotSeen' => $notifNotSeen,
                'shouldNotify' => $shouldNotify,
                'weekList' => $weekList,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
    }

    protected function generateWeekList()
    {
        $startDate = new \DateTime('now');
        $endDate = (clone $startDate)->add(new \DateInterval('P6M'));

        $currentWeek = clone $startDate;
        $currentWeek->modify('this week'); // Récupérer le début de la semaine actuelle

        $weekList = [];

        // Créer un formateur de date pour le format français
        $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);

        while ($currentWeek < $endDate) {
            $startOfWeek = clone $currentWeek;
            $endOfWeek = clone $currentWeek;

            // Trouver le dimanche de la semaine
            $endOfWeek->modify('sunday');

            $weekString = sprintf(
                'Semaine %s - %s / %s',
                $startOfWeek->format('W'),
                $formatter->format($startOfWeek),
                $formatter->format($endOfWeek)
            );

            // Ajouter la date de début et de fin de la semaine à la structure
            $weekList[] = [
                'weekString' => $weekString,
                'startOfWeek' => $startOfWeek->format('Y-m-d'),
                'endOfWeek' => $endOfWeek->format('Y-m-d'),
            ];

            $currentWeek->modify('next week'); // Passer à la semaine suivante
        }

        return $weekList;
    }


}
