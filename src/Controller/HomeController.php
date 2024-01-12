<?php

namespace App\Controller;

use App\Repository\SubjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CardsRepository;
use App\Repository\TypesRepository;
use Symfony\Bundle\SecurityBundle\Security;

class HomeController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_home')]
    public function index(CardsRepository $cardsRepository, TypesRepository $typesRepository, SubjectsRepository $subjectsRepository): Response
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

        $showParams = false;

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,
            $user = $this->getUser();
            $username = $user->getUsrPseudo();
            $name = $user->getUsrName();
            $firstname = $user->getUsrFirstname();
            $email = $user->getUsrMail();
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'username' => $username,
                'name' => $name,
                'firstname' => $firstname,
                'email' => $email,
                'cardData' => $cardData,
                'showParams' => $showParams,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
    }
}
