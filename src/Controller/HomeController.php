<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\SubjectsRepository;
use App\Repository\TypesRepository;
use App\Repository\NotifUsersRepository;
use App\Repository\UsersCardsRepository;
use App\Repository\UsersRepository;
use App\Repository\CardsRepository;
use App\Repository\ValidationRepository;

use App\Service\NotifService;
use App\Service\UserCardsService;
use App\Service\DateTimeConverter;

use App\Entity\Cards;
use App\Entity\UsersCards;

use App\Form\CardsType;


class HomeController extends AbstractController
{
    protected $security;
    protected $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository,
        NotifUsersRepository $notifUserRepository,
        UsersCardsRepository $userCardsRepository,
        ValidationRepository $validationRepository,

        NotifService $notificationsService,
        UserCardsService $userCardsService,
        DateTimeConverter $dateTimeConverter
    ): Response {

        // ------------------------------ CARDS ------------------------------//

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,
            $user = $this->getUser();
            // User data
            $username = $user->getUsrPseudo();
            $lastname = $user->getUsrName();
            $firstname = $user->getUsrFirstname();

            $cardsData = $userCardsService->getUserCards($user, $userCardsRepository, $typesRepository, $subjectsRepository, $dateTimeConverter, $validationRepository);

            return $this->render('home/index.html.twig', [
                'username' => $username,
                'lastname' => $lastname,
                'firstname' => $firstname,

                'cardsData' => $cardsData,
                'detailsCard' => null,
                
                'notifSeen' => $notificationsService->getUserNotifications($user, $notifUserRepository)['notifSeen'],
                'notifNotSeen' => $notificationsService->getUserNotifications($user, $notifUserRepository)['notifNotSeen'],
                'shouldNotify' => $notificationsService->getUserNotifications($user, $notifUserRepository)['shouldNotify'],

                'showParams' => false,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/list', name: 'app_home_list')]
    public function getListContent(
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository,
        NotifUsersRepository $notifUserRepository,
        UsersCardsRepository $userCardsRepository,

        NotifService $notificationsService,
        UserCardsService $userCardsService,
        DateTimeConverter $dateTimeConverter,
        ValidationRepository $validationRepository
    ): Response {
        $showParams = true;

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,
            $user = $this->getUser();

            $username = $user->getUsrPseudo();
            $lastname = $user->getUsrName();
            $firstname = $user->getUsrFirstname();

            $weekList = $this->generateWeekList();
            $cardsData = $userCardsService->getUserCards($user, $userCardsRepository, $typesRepository, $subjectsRepository, $dateTimeConverter, $validationRepository);

            $homeworkReminder = $user->isUsrHomeworkReminder();
            $examReminder = $user->isUsrExamReminder();
            $newReminder = $user->isUsrNewReminder();
            $modifReminder = $user->isUsrModifReminder();
            $cookies = $user->isUsrCookies();

            return $this->render('home/list.html.twig', [
                'controller_name' => 'HomeController',
                'username' => $username,
                'lastname' => $lastname,
                'firstname' => $firstname,

                'weekList' => $weekList,
                'cardsData' => $cardsData,
                'detailsCard' => null,

                'notifSeen' => $notificationsService->getUserNotifications($user, $notifUserRepository)['notifSeen'],
                'notifNotSeen' => $notificationsService->getUserNotifications($user, $notifUserRepository)['notifNotSeen'],
                'shouldNotify' => $notificationsService->getUserNotifications($user, $notifUserRepository)['shouldNotify'],

                'showParams' => $showParams,
                'homeworkReminder' => $homeworkReminder,
                'examReminder' => $examReminder,
                'newReminder' => $newReminder,
                'modifReminder' => $modifReminder,

                'cookies' => $cookies,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }




        if($this->getUser()){
            $user = $this->getUser();

            $cardsData = $userCardsService->getUserCards($user, $userCardsRepository, $typesRepository, $subjectsRepository, $dateTimeConverter, $usersValidationRepository);
            $content = $this->renderView('home/list.html.twig', ['cardsData' => $cardsData]);

            return new Response($content, Response::HTTP_OK, ['Content-Type' => 'text/html']);
        }

        return $this->redirectToRoute('app_login');
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
