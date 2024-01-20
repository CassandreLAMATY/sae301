<?php
// -------------------------------- USERCARDS ------------------------------- //
namespace App\Service;

use App\Service\DateTimeConverter;

class UserCardsService
{
    public function getUserCards($user, $userCardsRepository, $typesRepository, $subjectsRepository, DateTimeConverter $dateTimeConverter)
    {
        // Selecting every card id by user id
        $cards = $userCardsRepository->findByUserIdNotOutdated($user->getUsrId());
        $cardsData = [];
        $paramsData = [];

        foreach ($cards as $card) {
            $cardData = [
                "id" => $card->getUcCrdId()->getCrdId(),
                "title" => $card->getUcCrdId()->getCrdTitle(),
                "description" => $card->getUcCrdId()->getCrdDesc(),
                "from" => $card->getUcCrdId()->getCrdFrom(),
                "stringFrom" => $card->getUcCrdId()->getCrdFrom() ? $dateTimeConverter->convertToString($card->getUcCrdId()->getCrdFrom()) : null,
                'start' => $card->getUcCrdId()->getCrdFrom() ? $card->getUcCrdId()->getCrdFrom()->format('Y-m-d') : null,
                "to" => $card->getUcCrdId()->getCrdTo(),
                "stringTo" => $dateTimeConverter->convertToString($card->getUcCrdId()->getCrdTo()),
                'end' => $card->getUcCrdId()->getCrdTo()->format('Y-m-d'),
                "timeLeft" => $card->getUcCrdId()->getTimeLeft(),
                "type" => $card->getUcCrdId()->getCrdTypId()->getTypName(),
                "typeId" => $card->getUcCrdId()->getCrdTypId()->getTypId(),
                "ref" => $card->getUcCrdId()->getCrdSbjId()->getSbjRef(),
                "subject" => $card->getUcCrdId()->getCrdSbjId()->GetSbjName(),
                "isValidated" => $card->getUcCrdId()->getIsValidated(),
                "isDone" => $card->isUcDone(),
            ];

            $timeEnd = $card->getUcCrdId()->getCrdTo();

            if ($card->getUcCrdId()->getCrdFrom()) {
                $timeEnd = $card->getUcCrdId()->getCrdFrom();
            }

            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            if ($timeEnd < $now) {
                continue;
            }

            $typeId = $card->getUcCrdId()->getCrdTypId();
            $type = $typesRepository->find($typeId);

            $subjectId = $card->getUcCrdId()->getCrdSbjId();
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

            if ($type) {
                $paramsData = [
                    'typeName' => $type->getTypName(),
                    'typeColor' => $type->getTypColor(),
                    'subjectRef' => $subject->getSbjRef(),
                    'subjectName' => $subject->getSbjName(),
                    'timeColor' => $timeColor,
                ];
            }

            $cardsData[] = ['card' => $cardData, 'params' => $paramsData];
        }

        return $cardsData;
    }
}

// ------------------------------ END USERCARDS ----------------------------- //
