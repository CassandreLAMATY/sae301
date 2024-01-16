<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CardsRepository;

class DetailsController extends AbstractController
{
    #[Route('/details', name: 'app_details')]
    public function getDetails(
        Request $request,
        CardsRepository $cardsRepository
    ): Response
    {
            $eventId = json_decode($request->getContent())->eventId;

            $card = $cardsRepository->find($eventId);
            //return $this->json($card);

        return $this->render('details/index.html.twig', [
          'detailsCard' => $card,
        ]);

    }
}
