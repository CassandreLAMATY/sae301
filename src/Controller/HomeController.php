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
    
    #[Route('/modify-cards/{id}', name: 'modify_cards', methods: ['POST'])]
    public function modifyCardForm(Request $request, EntityManagerInterface $entityManager, CardsRepository $cardsRepository, SubjectsRepository $subjectsRepository, $id): Response
    {
        // Récupérez la carte existante depuis la base de données
        $card = $cardsRepository->find($id);

        if (!$card) {
            throw $this->createNotFoundException('La carte avec l\'ID ' . $id . ' n\'existe pas.');
        }

        // Récupérez les données JSON envoyées depuis le client
        $jsonData = json_decode($request->getContent(), true);

        // Modifiez les propriétés de la carte en fonction des données reçues
        // Assurez-vous d'ajuster ces lignes en fonction de vos besoins spécifiques
        $card->setCrdCreatedAt(new \DateTimeImmutable());
        $card->setIsValidated(0);

        // Par exemple, si vous avez un champ nommé "event_name"
        if (isset($jsonData['event_name'])) {
            $card->setCrdTitle($jsonData['crd_title']);
        }

        // Vous pouvez continuer d'ajuster les propriétés en fonction de vos besoins

        // Enregistrez les modifications dans la base de données
        $entityManager->flush();

        // Vous pouvez renvoyer une réponse appropriée si nécessaire
        return new Response('La carte a été modifiée avec succès.', 200);
    }
}