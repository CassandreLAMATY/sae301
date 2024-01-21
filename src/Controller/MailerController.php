<?php
// src/Controller/MailerController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Address;
use App\Repository\CardsRepository;
use App\Repository\SubjectsRepository;
use App\Repository\TypesRepository;

class MailerController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function sendEmail(
        MailerInterface $mailer,
        CardsRepository $cardsRepository,
        TypesRepository $typesRepository,
        SubjectsRepository $subjectsRepository,
    ): Response {
        $cards = $cardsRepository->findAll();
        $cardData = [];

        //TODO : link every variable to the actual data from the create and modification forms

        $mail_type = 'creation';
        // $action_by = $mail_type;

        $crd_title = 'Partiel d\'UI'; // Replace with actual data from $cards or other source
        $typ_name = 'Examen'; // Replace with actual data from $types or other source
        $crd_desc = 'Description descivant le partiel d\'UI'; // Replace with actual data from $cards or other source
        $sbj_name = 'WRA309D - Création et design interactif (UI)'; // Replace with actual data from $subjects or other source
        $crd_to = '2024-01-21 08:00:00'; // Replace with actual data from $cards or other source
        $crd_date = date('d-m-Y', strtotime($crd_to)); // Extract only the date from $crd_to
        $crd_time = date('H:i', strtotime($crd_to)); // Extract only the time from $crd_to
        $usr_name = 'Leane Berlo'; // Replace with actual data from $cards or other source
        $usr_semester = 'S3'; // Replace with actual data from $cards or other source
        $usr_group = 'E'; // Replace with actual data from $cards or other source
        $crd_modif_at = '2024-01-17 08:00:00'; // Replace with actual data from $cards or other source
        $crd_modif_date = date('d-m-Y', strtotime($crd_modif_at)); // Extract only the date from $crd_modif_at
        $crd_modif_time = date('H:i', strtotime($crd_modif_at)); // Extract only the time from $crd_modif_at

        // Switch case for $mail_title
        switch ($mail_type) {
            case 'creation':
                $mail_title = 'Nouvel évènement ajouté !';
                $action_by = 'Ajouté par : ';
                $usr_name = 'Leane Berlo';
                $usr_semester = 'S3';
                $usr_group = 'E';
                $crd_modif_date = date('d-m-Y', strtotime($crd_modif_at));
                $crd_modif_time = date('H:i', strtotime($crd_modif_at));
                break;
            case 'modification':
                $mail_title = 'Évènement modifié !';
                $action_by = 'Modifié par : ';
                $usr_name = 'Leane Berlo';
                $usr_semester = 'S3';
                $usr_group = 'E';
                $crd_modif_date = date('d-m-Y', strtotime($crd_modif_at));
                $crd_modif_time = date('H:i', strtotime($crd_modif_at));
                break;
            case 'signalement':
                $mail_title = 'Évènement signalé !';
                $action_by = 'Signalé par : ';
                $usr_name = 'Leane Berlo';
                $usr_semester = 'S3';
                $usr_group = 'E';
                $crd_modif_date = date('d-m-Y', strtotime($crd_modif_at));
                $crd_modif_time = date('H:i', strtotime($crd_modif_at));
                break;
            case 'rappel rendu':
                $mail_title = 'Plus que quelques jours avant le rendu !';
                $action_by = ' ';
                $usr_name = ' ';
                $usr_semester = ' ';
                $usr_group = ' ';
                $crd_modif_date = ' ';
                $crd_modif_time = ' ';
                break;
            case 'rappel examen':
                $mail_title = 'Plus que quelques jours avant l\'examen !';
                $action_by = ' ';
                $usr_name = ' ';
                $usr_semester = ' ';
                $usr_group = ' ';
                $crd_modif_date = ' ';
                $crd_modif_time = ' ';
                break;
            default:
                $mail_title = ' ';
                $action_by = ' ';
                $usr_name = ' ';
                $usr_semester = ' ';
                $usr_group = ' ';
                $crd_modif_date = ' ';
                $crd_modif_time = ' ';
                break;
        }

        $email = (new TemplatedEmail())
            ->from('fabien@example.com') // Replace with actual data from form
            ->to(new Address('leane.berlo@univ-reims.fr'))
            ->subject('Nouvelle notification!')
            // path of the Twig template to render
            ->htmlTemplate('mailer/index.html.twig')
            // pass variables (name => value) to the template
            ->context([
                'mail_title' => $mail_title,
                'crd_title' => $crd_title,
                'typ_name' => $typ_name,
                'crd_desc' => $crd_desc,
                'sbj_name' => $sbj_name,
                'crd_to' => $crd_to,
                'crd_date' => $crd_date,
                'crd_time' => $crd_time,
                'usr_name' => $usr_name,
                'usr_semester' => $usr_semester,
                'usr_group' => $usr_group,
                'crd_modif_date' => $crd_modif_date,
                'crd_modif_time' => $crd_modif_time,
                'action_by' => $action_by,
            ]);

        // ...
        $mailer->send($email);
        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
            'mail_title' => $mail_title,
            'crd_title' => $crd_title,
            'typ_name' => $typ_name,
            'crd_desc' => $crd_desc,
            'sbj_name' => $sbj_name,
            'crd_to' => $crd_to,
            'crd_date' => $crd_date,
            'crd_time' => $crd_time,
            'usr_name' => $usr_name,
            'usr_semester' => $usr_semester,
            'usr_group' => $usr_group,
            'crd_modif_date' => $crd_modif_date,
            'crd_modif_time' => $crd_modif_time,
            'action_by' => $action_by,
        ]);

        return $this->redirectToRoute('app_home');
    }
}
