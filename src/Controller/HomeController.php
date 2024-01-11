<?php

namespace App\Controller;

use App\Repository\SubjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CardsRepository;
use App\Repository\TypesRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository
    ): Response {
        $cards = $cardsRepository->findAll();

        $cardData = [];

        foreach ($cards as $card) {
            $timeEnd = $card->getCrdTo();
            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            $timeEnd->modify('-1 hour');

            //if timeEnd is before now, skip this card
            if ($timeEnd < $now) {
                continue;
            }

            $typeId = $card->getCrdTypId();
            $type = $typesRepository->find($typeId);

            $subjectId = $card->getCrdSbjId();
            $subject = $subjectsRepository->find($subjectId);

            if ($type !== null) {
                $cardData[] = [
                    'card' => $card,
                    'typeName' => $type->getTypName(),
                    'typeColor' => $type->getTypColor(),
                    'subjectName' => $subject->getSbjName(),
                    'subjectColor' => $subject->getSbjColor(),
                ];
            }
        }

        return $this->render('home/index.html.twig', [
            'cardData' => $cardData,
        ]);
    }
}
