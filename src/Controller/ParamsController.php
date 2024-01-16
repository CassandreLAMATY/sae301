<?php

namespace App\Controller;

use App\Repository\SubjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CardsRepository;
use App\Repository\TypesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ParamsController extends AbstractController
{
        private $security;
        private $entityManager;

        public function __construct(Security $security, EntityManagerInterface $entityManager)
        {
                $this->security = $security;
                $this->entityManager = $entityManager;
        }

        #[Route('/', name: 'app_home_params')]
        public function index(Request $request): Response
        {
                if (!$this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                        return $this->redirectToRoute('app_login');
                }

                $user = $this->getUser();
                $username = $user->getUsrPseudo();
                $name = $user->getUsrName();
                $firstname = $user->getUsrFirstname();
                $email = $user->getUsrMail();
                $showParams = true;
                $homeworkReminder = $user->isUsrHomeworkReminder();
                $examReminder = $user->isUsrExamReminder();
                $newReminder = $user->isUsrNewReminder();
                $modifReminder = $user->isUsrModifReminder();
                $cookies = $user->isUsrCookies();

                if ($request->isMethod('POST')) {
                        if ($request->request->has('homeworkReminder')) {
                                $homeworkReminder = !$homeworkReminder;
                                $user->setUsrHomeworkReminder($homeworkReminder);
                        }
                        if ($request->request->has('examReminder')) {
                                $examReminder = !$examReminder;
                                $user->setUsrExamReminder($examReminder);
                        }
                        if ($request->request->has('newReminder')) {
                                $newReminder = !$newReminder;
                                $user->setUsrNewReminder($newReminder);
                        }
                        if ($request->request->has('modifReminder')) {
                                $modifReminder = !$modifReminder;
                                $user->setUsrModifReminder($modifReminder);
                        }
                        if ($request->request->has('cookies')) {
                                $cookies = !$cookies;
                                $user->setUsrCookies($cookies);
                        }


                        $this->entityManager->persist($user);
                        $this->entityManager->flush();
                }

                return $this->render('home/index.html.twig', [
                        'controller_name' => 'ParamsController',
                        'username' => $username,
                        'name' => $name,
                        'firstname' => $firstname,
                        'email' => $email,
                        'cardData' => [], // Add appropriate cardData if needed
                        'showParams' => $showParams,
                        'homeworkReminder' => $homeworkReminder,
                        'examReminder' => $examReminder,
                        'newReminder' => $newReminder,
                        'modifReminder' => $modifReminder,
                        'cookies' => $cookies,
                        'detailsCard' => null,
                ]);
        }
}
