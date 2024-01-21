<?php

namespace App\Controller;

use App\Repository\CardsRepository;
use App\Repository\SubjectsRepository;
use App\Repository\TypesRepository;
use App\Repository\UsersValidationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    #[Route('/details', name: 'app_details')]
    public function getDetails(
        Request $request,
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository,
        UsersValidationRepository $usersValidationRepository
    ): Response {
        $cardId = json_decode($request->getContent())->cardId;

        $card = $cardsRepository->find($cardId);

        if ($card) {
            $timeEnd = $card->getCrdTo();
            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            $typeId = $card->getCrdTyp();
            $type = $typesRepository->find($typeId);

            $subjectId = $card->getCrdSbj();
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

            $validations = $usersValidationRepository->findByCardId($cardId);
            $validationNumber = 0;
            foreach ($validations as $validation) {
                if ($validation->getUvValidated() > 0) {
                    $validationNumber += $validation->getUvValidated();
                }
            }

            $cardData = [];

            if ($type !== null) {
                $cardData[] = [
                    'card' => $card,
                    'typeName' => $type->getTypName(),
                    'typeColor' => $type->getTypColor(),
                    'subjectName' => $subject->getSbjName(),
                    'timeColor' => $timeColor,
                    'validationNumber' => $validationNumber,
                ];
            }
        }

        return $this->render('details/index.html.twig', ['detailsCard' => $cardData,]);
    }
}
