<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\SubjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CardsRepository;
use App\Repository\TypesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class HomeController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request, CardsRepository $cardsRepository, TypesRepository $typesRepository, SubjectsRepository $subjectsRepository, EntityManagerInterface $entityManager): Response
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
                    'subjectName' => $subject->getSbjName(),
                    'subjectColor' => $subject->getSbjColor(),
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

            if ($request->isMethod('POST')) {
                $homeworkReminder = !$homeworkReminder;
                $user->setUsrHomeworkReminder($homeworkReminder);
                $entityManager->persist($user);
                $entityManager->flush();
            }

            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'username' => $username,
                'name' => $name,
                'firstname' => $firstname,
                'email' => $email,
                'cardData' => $cardData,
                'showParams' => $showParams,
                'homeworkReminder' => $homeworkReminder,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
    }
}
