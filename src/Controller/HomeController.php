<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\SubjectsRepository;
use App\Repository\TypesRepository;
use App\Repository\NotifUsersRepository;
use App\Repository\UsersCardsRepository;


use App\Service\NotifService;
use App\Service\UserCardsService;
use App\Service\DateTimeConverter;


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

        NotifService $notificationsService,
        UserCardsService $userCardsService,
        DateTimeConverter $dateTimeConverter
    ): Response {

        // ------------------------------ CARDS ------------------------------//
        /* usort($cardData, function ($a, $b) {
            return $a['card']->getCrdTo() <=> $b['card']->getCrdTo();
        }); */

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,
            $user = $this->getUser();
            // User data
            $username = $user->getUsrPseudo();
            $lastname = $user->getUsrName();
            $firstname = $user->getUsrFirstname();

            $cardsData = $userCardsService->getUserCards($user, $userCardsRepository, $typesRepository, $subjectsRepository, $dateTimeConverter);

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

    #[Route('/home-list', name: 'app_home_list')]
    public function getListContent(
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository,
        NotifUsersRepository $notifUserRepository,
        UsersCardsRepository $userCardsRepository,

        NotifService $notificationsService,
        UserCardsService $userCardsService,
        DateTimeConverter $dateTimeConverter
    ): Response {
        $showParams = true;

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,
            $user = $this->getUser();

            $username = $user->getUsrPseudo();
            $lastname = $user->getUsrName();
            $firstname = $user->getUsrFirstname();

            $cardsData = $userCardsService->getUserCards($user, $userCardsRepository, $typesRepository, $subjectsRepository, $dateTimeConverter);

            $homeworkReminder = $user->isUsrHomeworkReminder();
            $examReminder = $user->isUsrExamReminder();
            $newReminder = $user->isUsrNewReminder();
            $modifReminder = $user->isUsrModifReminder();
            $cookies = $user->isUsrCookies();

            // if ($request->isMethod('POST')) {
            //     if ($request->request->has('homeworkReminder')) {
            //         $homeworkReminder = !$homeworkReminder;
            //         $user->setUsrHomeworkReminder($homeworkReminder);
            //     }
            //     if ($request->request->has('examReminder')) {
            //         $examReminder = !$examReminder;
            //         $user->setUsrExamReminder($examReminder);
            //     }
            //     if ($request->request->has('newReminder')) {
            //         $newReminder = !$newReminder;
            //         $user->setUsrNewReminder($newReminder);
            //     }
            //     if ($request->request->has('modifReminder')) {
            //         $modifReminder = !$modifReminder;
            //         $user->setUsrModifReminder($modifReminder);
            //     }
            //     if ($request->request->has('cookies')) {
            //         $cookies = !$cookies;
            //         $user->setUsrCookies($cookies);
            //     }

            //     $entityManager->persist($user);
            //     $entityManager->flush();
            // }

            /* return $this->forward(ParamsController::class . '::index', [
                'request' => $request,
                // 'cardsRepository' => $cardsRepository, // Pass any other dependencies needed in ParamsController
                // 'typesRepository' => $typesRepository,
                // 'subjectsRepository' => $subjectsRepository,
            ]); */

            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'username' => $username,
                'lastname' => $lastname,
                'firstname' => $firstname,

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

            $cardsData = $userCardsService->getUserCards($user, $userCardsRepository, $typesRepository, $subjectsRepository, $dateTimeConverter);
            $content = $this->renderView('home/list.html.twig', ['cardsData' => $cardsData]);

            return new Response($content, Response::HTTP_OK, ['Content-Type' => 'text/html']);
        }

        return $this->redirectToRoute('app_login');
    }
}