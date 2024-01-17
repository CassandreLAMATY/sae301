<?php

namespace App\Controller;

use App\Repository\CardsRepository;
use App\Repository\SubjectsRepository;
use App\Repository\TypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController {
    #[Route('/details', name: 'app_details')]
    public function getDetails(
        Request $request,
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository): Response {
        $eventId = json_decode($request->getContent())->eventId;

        $card = $cardsRepository->find($eventId);

        if ($card) {
            $timeEnd = $card->getCrdTo();
            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            $typeId = $card->getCrdTypId();
            $type = $typesRepository->find($typeId);

            $subjectId = $card->getCrdSbjId();
            $subject = $subjectsRepository->find($subjectId);

            $timeleft = $now->diff($timeEnd);
            $dayLeft = $timeleft->format('%a');
            $dayLeft = (int)$dayLeft;

            $timeColor = 'var(--grey)';

            $validated = [];
            $validatedBy = [];

            if ($dayLeft < 8) {
                $timeColor = 'var(--accent-orange)';
            }

            if ($dayLeft < 3) {
                $timeColor = 'var(--accent-red)';
            }

            $cardData = [];

            if ($type !== null) {
                $cardData[] = ['card' => $card, 'typeName' => $type->getTypName(), 'typeColor' => $type->getTypColor(), 'subjectName' => $subject->getSbjName(), 'timeColor' => $timeColor, $validated, $validatedBy];
            }
        }

        return $this->render('details/index.html.twig', ['detailsCard' => $cardData,

        ]);
    }
}
