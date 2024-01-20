<?php
// -------------------------------- USERCARDS ------------------------------- //
namespace App\Service;

use App\Service\DateTimeConverter;

class UserCardsService {
    public function getUserCards($user, $userCardsRepository, $typesRepository, $subjectsRepository, DateTimeConverter $dateTimeConverter) {
        // Selecting every card id by user id
        $cards = $userCardsRepository->findByUserIdNotOutdated($user->getUsrId());
        $cardsData = [];
        $paramsData = [];

        foreach ($cards as $card) {
            $cardData = [
                "id" => $card->getUcCrd()->getCrdId(),
                "title" => $card->getUcCrd()->getCrdTitle(),
                "description" => $card->getUcCrd()->getCrdDesc(),
                "from" => $card->getUcCrd()->getCrdFrom(),
                "stringFrom" => $card->getUcCrd()->getCrdFrom() ? $dateTimeConverter->convertToString($card->getUcCrd()->getCrdFrom()) : null,
                "to" => $card->getUcCrd()->getCrdTo(),
                "stringTo" => $dateTimeConverter->convertToString($card->getUcCrd()->getCrdTo()),
                "timeLeft" => $card->getUcCrd()->getTimeLeft(),
                "type" => $card->getUcCrd()->getCrdTyp()->getTypName(),
                "typeId" => $card->getUcCrd()->getCrdTyp()->getTypId(),
                "ref" => $card->getUcCrd()->getCrdSbj() ? $card->getUcCrd()->getCrdSbj()->getSbjRef() : null,
                "subject" => $card->getUcCrd()->getCrdSbj() ? $card->getUcCrd()->getCrdSbj()->GetSbjName() : null,
                "isValidated" => $card->getUcCrd()->getIsValidated(),
            ];

            $timeEnd = $card->getUcCrd()->getCrdTo();

            if($card->getUcCrd()->getCrdFrom()){
                $timeEnd = $card->getUcCrd()->getCrdFrom();
            }

            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));

            $typeId = $card->getUcCrd()->getCrdTyp();
            $type = $typesRepository->find($typeId);

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

            if ($type) {
                $paramsData = [
                    'typeName' => $type->getTypName(),
                    'typeColor' => $type->getTypColor(),
                    'timeColor' => $timeColor,
                ];
            }
            $cardsData[] = ['card' => $cardData, 'params' => $paramsData];
        }

        return $cardsData;
    }
}

// ------------------------------ END USERCARDS ----------------------------- //
