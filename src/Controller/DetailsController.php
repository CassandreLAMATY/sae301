<?php

namespace App\Controller;

use App\Repository\CardsRepository;
use App\Repository\SubjectsRepository;
use App\Repository\TypesRepository;
use App\Repository\ValidationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    #[Route('/details/{eventId}', name: 'app_details')]
    public function getDetails(
        int $eventId, 
        Request $request,
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository,
        ValidationRepository $validationRepository
        ): Response {
        $card = $cardsRepository->find($eventId);

        if ($card) {
            $timeEnd = $card->getCrdTo();
            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            $typeId = $card->getCrdTyp();
            $type = $typesRepository->find($typeId);
            
            $subject = null;
            if( $card->getCrdSbj() ) {
                $subjectId = $card->getCrdSbj();
                $subject = $subjectsRepository->find($subjectId);
            }

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

            $validations = $validationRepository->findByCardId($eventId);
            $validationNumber = count($validations);
            $cardData = [];
            $user = $this->getUser();

            if ($type !== null) {
                $cardData[] = [ 
                    'card' => $card, 
                    'typeName' => $type->getTypName(), 
                    'typeColor' => $type->getTypColor(), 
                    'timeColor' => $timeColor,
                    'subjectName' => "",
                    'subjectRef' => "",
                    'validationNumber' => $validationNumber,
                    "didUserValidate" => $validationRepository->didUserValidate($user->getUsrId(), $card->getCrdId()),
                ];
                if($subject !== null) {
                    $cardData[0]['subjectName'] = $subject->getSbjName();
                    $cardData[0]['subjectRef'] = $subject->getSbjRef();
                }
            }
        }

        return $this->render('details/index.html.twig', ['detailsCard' => $cardData]);
    }
}
