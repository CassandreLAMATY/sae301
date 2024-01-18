<?php

namespace App\Controller;

use App\Entity\Users;
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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class HomeController extends AbstractController
{
    private $entityManager;
    protected $security;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository,
        EntityManagerInterface $entityManager,
        NotificationsRepository $notificationsRepository,
        NotifUsersRepository $notifUserRepository
    ): Response {

        // -------------------------- NOTIFICATIONS --------------------------//

        // Selecting the user
        $user = $this->getUser();

        // Selecting every notification id by user id
        $notifications = $notifUserRepository->findByUserID($user->getUsrId());
        $notifSeen = [];
        $notifNotSeen = [];

        // Creating an array with every notification id
        $shouldNotify = false;
        foreach ($notifications as $notif) {
            if($notif->isNuSeen()) {
                $notifSeen[] = $notif;
            } else {
                $notifNotSeen[] = $notif;
            }
        }

        // ----------------------- END NOTIFICATIONS ------------------------ //

        // ------------------------------ CARDS ------------------------------//

        $cards = $cardsRepository->findAll();
        $cardData = [];

        foreach ($cards as $card) {
            $timeEnd = $card->getCrdTo();

            if($card->getCrdFrom()){
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
                'showParams' => false,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/home-list', name: 'app_home_list')]
    public function getListContent(
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository
    ): Response {
        $cards = $cardsRepository->findAll();
        $cardData = [];

        foreach ($cards as $card) {

            $timeEnd = $card->getCrdTo();

            if($card->getCrdFrom()){
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

        $showParams = true;

        usort($cardData, function ($a, $b) {
            return $a['card']->getCrdTo() <=> $b['card']->getCrdTo();
        });

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,
            $user = $this->getUser();
            $username = $user->getUsrPseudo();
            $name = $user->getUsrName();
            $firstname = $user->getUsrFirstname();
            $email = $user->getUsrMail();
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

            return $this->forward(ParamsController::class . '::index', [
                'request' => $request,
                // 'cardsRepository' => $cardsRepository, // Pass any other dependencies needed in ParamsController
                // 'typesRepository' => $typesRepository,
                // 'subjectsRepository' => $subjectsRepository,
            ]);

            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'username' => $username,
                'name' => $name,
                'firstname' => $firstname,
                'email' => $email,
                'cardData' => $cardData,
                'showParams' => $showParams,
                'homeworkReminder' => $homeworkReminder,
                'examReminder' => $examReminder,
                'newReminder' => $newReminder,
                'modifReminder' => $modifReminder,
                'cookies' => $cookies,
                'detailsCard' => null,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
        $content = $this->renderView('home/list.html.twig', ['cardData' => $cardData]);

        return new Response($content, Response::HTTP_OK, ['Content-Type' => 'text/html']);
    }
}
