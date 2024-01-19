<?php

namespace App\Controller;

use App\Repository\SubjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubjectsDataController extends AbstractController
{
    #[Route('/subjects/data', name: 'app_subjects_data')]
    public function getCalendarData(
        SubjectsRepository $subjectsRepository

    ): Response {
        $subjects = $subjectsRepository->findAll();

        $options = '';
        foreach ($subjects as $subject) {
            $options .= '<label for="' . $subject->getId() . '"><input type="checkbox" id="' . $subject->getId() . '" value="'. $subject->getSbjRef() . ' - ' . $subject->getSbjName() .'">' . $subject->getSbjRef() . ' - '  . $subject->getSbjName() . '</label>';
        }

        return $this->json($options);
    }
}
