<?php

namespace App\Controller;

use App\Repository\CardsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarDataController extends AbstractController
{
    #[Route('/calendar/data', name: 'app_calendar_data')]
    public function getCalendarData(
        CardsRepository $cardsRepository
    ): Response {
        $cards = $cardsRepository->findAll();

        foreach ($cards as $card) {
            if($card->getCrdFrom()) {
                $data[] = [
                    'title' => $card->getCrdTitle(),
                    'start' => $card->getCrdFrom()->format('Y-m-d'),
                    'end' => $card->getCrdTo()->format('Y-m-d'),
                    'hour' => $card->getCrdTo()->format('H:i'),
                    'subject' => $card->getCrdSbjId(),
                    'type' => $card->getCrdTypId(),
                    'id' => $card->getId(),
                    'isValidated' => $card->getIsValidated(),
                ];
                continue;
            }
            $data[] = [
                'title' => $card->getCrdTitle(),
                'start' => $card->getCrdTo()->format('Y-m-d'),
                'hour' => $card->getCrdTo()->format('H:i'),
                'subject' => $card->getCrdSbjId(),
                'type' => $card->getCrdTypId(),
                'id' => $card->getId(),
                'isValidated' => $card->getIsValidated(),
            ];
        }

        return $this->json($data);
    }
}
