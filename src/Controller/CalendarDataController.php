<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersCardsRepository;

class CalendarDataController extends AbstractController
{
    #[Route('/calendar/data', name: 'app_calendar_data')]
    public function getCalendarData(
        UsersCardsRepository $userCardsRepository
    ): Response {
        $user = $this->getUser();
        $cards = $userCardsRepository->findByUserId($user->getUsrId());

        foreach ($cards as $card) {
            if($card->getUcCrdId()->getCrdFrom()) {
                $data[] = [
                    "id" => $card->getUcCrdId()->getCrdId(),
                    "title" => $card->getUcCrdId()->getCrdTitle(),
                    'subject' => $card->getUcCrdId()->getCrdSbjId(),
                    'type' => $card->getUcCrdId()->getCrdTypId(),
                    'start' => $card->getUcCrdId()->getCrdFrom()->format('Y-m-d'),
                    'end' => $card->getUcCrdId()->getCrdTo()->format('Y-m-d'),
                    'hour' => $card->getUcCrdId()->getCrdTo()->format('H:i'),
                    "isValidated" => $card->getUcCrdId()->getIsValidated(),
                ];
                continue;
            }
            $data[] = [
                "id" => $card->getUcCrdId()->getCrdId(),
                "title" => $card->getUcCrdId()->getCrdTitle(),
                'subject' => $card->getUcCrdId()->getCrdSbjId(),
                'type' => $card->getUcCrdId()->getCrdTypId(),
                'start' => $card->getUcCrdId()->getCrdTo()->format('Y-m-d'),
                'hour' => $card->getUcCrdId()->getCrdTo()->format('H:i'),
                "isValidated" => $card->getUcCrdId()->getIsValidated(),
            ];
        }
        return $this->json($data);
    }
}
