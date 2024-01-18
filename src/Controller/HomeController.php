<?php

namespace App\Controller;

use App\Repository\SubjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CardsRepository;
use App\Repository\TypesRepository;
use App\Repository\NotificationsRepository;
use App\Repository\UsersRepository;
use App\Repository\NotifUsersRepository;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Cards;
use App\Entity\Subjects;
use App\Entity\UsersCards;
use App\Form\CardsType;
use Doctrine\ORM\EntityManagerInterface;




class HomeController extends AbstractController
{
    protected $security;
    private $entityManager;


    public function __construct(Security $security, EntityManagerInterface $entityManager)
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
    ): Response
    {

        // -------------------------- NOTIFICATIONS --------------------------//

        // Selecting the user
        $user = $this->getUser();

        // Selecting every notification id by user id
        $nu = $notifUserRepository->findByUserID($user->getUsrId());

        // Creating an array with every notification id
        $notificationsId = [];
        foreach ($nu as $notif) {
            $notificationsId[] = $notif->getNuNot();
        }

        $notifications = $notificationsRepository->findById($notificationsId);

        $shouldNotify = false;
        foreach ($notifications as $notification) {
            if (!$notification->isNotIsSeen()) {
                $shouldNotify = true;
            }
        }

        // ----------------------- END NOTIFICATIONS ------------------------ //



        $cards = $cardsRepository->findAll();
        $cardData = [];

        foreach ($cards as $card) {
            $timeEnd = $card->getCrdTo();
            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            //if timeEnd is before now, skip this card
            if ($timeEnd < $now) {
                continue;
            }

            $typeId = $card->getCrdTyp();
            $type = $typesRepository->find($typeId);


            $timeleft = $now->diff($timeEnd);
            $dayLeft = $timeleft->format('%a');
            $dayLeft = (int)$dayLeft;

            $timeColor = 'var(--grey)';

            if($dayLeft < 8) {
                $timeColor= 'var(--accent-orange)';
            }

            if ($dayLeft < 3) {
                $timeColor= 'var(--accent-red)';
            }

            $subjectId = $card->getCrdSbj();

            $subject = $subjectsRepository->find($subjectId);


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
                'controller_name' => 'HomeController',
                'username' => $username,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'email' => $email,
                'cardData' => $cardData,

                'detailsCard' => null,

                'notifications' => $notifications,
                'shouldNotify' => $shouldNotify,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
    }
    private function getOtherTpOfTd($tp)
    {
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


    #[Route('/home-list', name: 'app_home_list')]
    public function getListContent(
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository
    ): Response
    {
        $cards = $cardsRepository->findAll();
        $cardData = [];

        foreach ($cards as $card) {
            $timeEnd = $card->getCrdTo();
            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            //if timeEnd is before now, skip this card
            if ($timeEnd < $now) {
                continue;
            }

            $typeId = $card->getCrdTyp();
            $type = $typesRepository->find($typeId);

            $subjectId = $card->getCrdSbj();
            $subject = $subjectsRepository->find($subjectId);

            $timeleft = $now->diff($timeEnd);
            $dayLeft = $timeleft->format('%a');
            $dayLeft = (int)$dayLeft;

            $timeColor = 'var(--grey)';

            if($dayLeft < 8) {
                $timeColor= 'var(--accent-orange)';
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

        $content = $this->renderView('home/list.html.twig', ['cardData' => $cardData]);

        return new Response($content, Response::HTTP_OK, ['Content-Type' => 'text/html']);
    }
}
