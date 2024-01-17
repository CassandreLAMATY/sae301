<?php

namespace App\Controller;

use App\Repository\SubjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CardsRepository;
use App\Repository\TypesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Cards;
use App\Entity\Subjects;
use App\Entity\UsersCards;
use App\Form\CardsType;
use Doctrine\ORM\EntityManagerInterface;
use App\EventListener\CardsFormListener;




class HomeController extends AbstractController
{
    private $security;
    private $entityManager;


    public function __construct(Security $security, EntityManagerInterface $entityManager, CardsFormListener $cardsFormListener)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(CardsRepository $cardsRepository, TypesRepository $typesRepository, SubjectsRepository $subjectsRepository): Response
    {
        $cards = $cardsRepository->findAll();
        $cardData = [];

        foreach ($cards as $card) {
            $timeEnd = $card->getCrdTo();
            $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
            $timeEnd->setTimezone(new \DateTimeZone('Europe/Paris'));

            //if timeEnd is before now, skip this card
            if ($timeEnd < $now) {
                continue;
            }

            $typeId = $card->getCrdTyp();
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

            $subjectId = $card->getCrdSbj();

            $subject = $subjectsRepository->find($subjectId);


            if ($type !== null) {

                $cardData[] = [
                    'card' => $card,
                    'typeName' => $type->getTypName(),
                    'typeColor' => $type->getTypColor(),
                    'subjectName' => $subject->getSbjName(),
                    'subjectColor' => $subject->getSbjColor(),
                    'timeColor' => $timeColor,
                ];
            }

        }
        usort($cardData, function ($a, $b) {
            return $a['card']->getCrdTo() <=> $b['card']->getCrdTo();
        });

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,
            $user = $this->getUser();
            $username = $user->getUsrPseudo();
            $name = $user->getUsrName();
            $firstname = $user->getUsrFirstname();
            $email = $user->getUsrMail();
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'username' => $username,
                'name' => $name,
                'firstname' => $firstname,
                'email' => $email,
                'cardData' => $cardData,
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
    }
    #[Route('/create-cards', name: 'create_cards')]
    public function createCardForm(Request $request, EntityManagerInterface $entityManager, SubjectsRepository $subjectsRepository): Response
    {
        $card = new Cards();
        //$UC = new UsersCards();


        $form = $this->createForm(CardsType::class, $card, [
            'action' => $this->generateUrl('create_cards'),
            'method' => 'POST',
            'attr' => ['id' => 'create-cards-form'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez les données dans la base de données ici
            $card = $form->getData();
            $card->setCrdCreatedAt(new \DateTimeImmutable());
            $card->setIsValidated(0);
            if($card->getCrdSbj() == null){
                $card->setCrdSbj($subjectsRepository->find(22));
            }
            $entityManager->persist($card);
            $entityManager->flush();
            // Redirigez l'utilisateur ou effectuez d'autres actions après la soumission réussie
            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/_created_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
