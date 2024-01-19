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

    private function getOtherTpOfTd($tp) {
        // Utilisez une correspondance simple
        switch ($tp) {
            case 'A':
                return 'B';
            case 'B':
                return 'A';
            case 'C':
                return 'D';
            case 'D':
                return 'C';
            case 'E':
                return 'F';
            case 'F':
                return 'E';
            case 'G':
                return 'H';
            case 'H':
                return 'G';
            // Ajoutez d'autres correspondances au besoin
            default:
                // Gestion du cas par défaut si le TP n'est pas reconnu
                return null;
        }
    }

    #[Route('/create-cards', name: 'create_cards')]
    public function createCardForm(Request $request, EntityManagerInterface $entityManager, SubjectsRepository $subjectsRepository, UsersRepository $usersRepository): Response
    {
        $card = new Cards();
        // usertp = les user avec usr_tp identique que celui de l'user connecté
        // Récupérez l'utilisateur connecté
        $currentUserSemester = $this->getUser()->getUsrSemester();
        $currentUserTp = $this->getUser()->getUsrTp();
        $currentUserOtherTpOfTd = $this->getOtherTpOfTd($currentUserTp);
// Construisez les conditions sous forme de tableau associatif
        $conditionsTD = [
            'usr_semester' => $currentUserSemester,
            'usr_tp' => [$currentUserTp,$currentUserOtherTpOfTd],
        ];
        $conditionsTP = [
            'usr_semester' => $currentUserSemester,
            'usr_tp' => $currentUserTp,
        ];




        $form = $this->createForm(CardsType::class, $card, [
            'action' => $this->generateUrl('create_cards'),
            'method' => 'POST',
            'attr' => ['id' => 'create-cards-form'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez les données dans la base de données ici
            $card = $form->getData();
           // dd($request->request->all()['cards']['crd_grp']);

            $card->setCrdCreatedAt(new \DateTimeImmutable());
            $card->setIsValidated(0);

            // remplir les userscards avec les bonnes conditions
            $users = $usersRepository->findBy($conditionsTP);
            //$crd_grpValue = $request->request->all()['crd_grp'];
            if($card->getCrdGrp() === 1) {
                $users = $usersRepository->findBy($conditionsTD);
            }
            // Créez un tableau pour stocker les ID des utilisateurs
            $usersId = [];
            foreach ($users as $user) {
                $usersId[] = $user->getUsrId();
            }
            if($card->getCrdSbj() == null){
                $card->setCrdSbj($subjectsRepository->find(22));
                $usersId= $usersRepository->findAll();
            }

            foreach ($usersId as $userId) {
                $UC = new UsersCards();
                $UC->setUcUsrId($usersRepository->find($userId));
                $UC->setUcCrdId($card);
                $UC->setUcDone(0);
                $entityManager->persist($UC);
            }

            $entityManager->persist($card);
            $entityManager->flush();

            // Redirigez l'utilisateur ou effectuez d'autres actions après la soumission réussie
            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/_created_form.html.twig', [
            'form' => $form->createView(),
        ]);
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