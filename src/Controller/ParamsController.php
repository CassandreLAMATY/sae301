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

        #[Route('/parametres', name: 'app_home_params')]
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
                $showParams = false;
                $homeworkReminder = $user->isUsrHomeworkReminder();
                $examReminder = $user->isUsrExamReminder();
                $newReminder = $user->isUsrNewReminder();
                $modifReminder = $user->isUsrModifReminder();
                $cookies = $user->isUsrCookies();

                if ($request->isMethod('POST')) {
                        //dd($request->request);
                        if ($request->request->has('homeworkReminder')) {
                                $homeworkReminder = $request->request->get('homeworkReminder') === 'true' ? true : false;
                                $user->setUsrHomeworkReminder($homeworkReminder);
                        }
                        if ($request->request->has('examReminder')) {
                                $examReminder = $request->request->get('examReminder') === 'true' ? true : false;
                                $user->setUsrExamReminder($examReminder);
                        }
                        if ($request->request->has('newReminder')) {
                                $newReminder = $request->request->get('newReminder') === 'true' ? true : false;
                                $user->setUsrNewReminder($newReminder);
                        }
                        if ($request->request->has('modifReminder')) {
                                $modifReminder = $request->request->get('modifReminder') === 'true' ? true : false;
                                $user->setUsrModifReminder($modifReminder);
                        }
                        if ($request->request->has('cookies')) {
                                $cookies = $request->request->get('cookies') === 'true' ? true : false;
                                $user->setUsrCookies($cookies);
                        }


                        $this->entityManager->persist($user);
                        $this->entityManager->flush();
                        return $this->json('ok'); //une réponse json valide avec ce que tu veux qui pourrait être récupéré par ton js
                }

                return $this->render('home/_params.html.twig', [
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
