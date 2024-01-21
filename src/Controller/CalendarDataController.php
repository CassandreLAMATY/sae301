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
        $data = [];

        foreach ($cards as $card) {
            if($card->getUcCrd()->getCrdFrom()) {
                $data[] = [
                    "id" => $card->getUcCrd()->getCrdId(),
                    "title" => $card->getUcCrd()->getCrdTitle(),
                    'subject' => $card->getUcCrd()->getCrdSbj(),
                    'type' => $card->getUcCrd()->getCrdTyp(),
                    'start' => $card->getUcCrd()->getCrdFrom()->format('Y-m-d'),
                    'end' => $card->getUcCrd()->getCrdTo()->format('Y-m-d'),
                    'hour' => $card->getUcCrd()->getCrdTo()->format('H:i'),
                    "isValidated" => $card->getUcCrd()->getIsValidated(),
                    "isDone" => $card->isUcDone(),
                ];
                continue;
            }
            $data[] = [
                "id" => $card->getUcCrd()->getCrdId(),
                "title" => $card->getUcCrd()->getCrdTitle(),
                'subject' => $card->getUcCrd()->getCrdSbj(),
                'type' => $card->getUcCrd()->getCrdTyp(),
                'start' => $card->getUcCrd()->getCrdTo()->format('Y-m-d'),
                'hour' => $card->getUcCrd()->getCrdTo()->format('H:i'),
                "isValidated" => $card->getUcCrd()->getIsValidated(),
                "isDone" => $card->isUcDone(),
            ];
        }
        return $this->json($data);
    }
}
