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
            $options .= '<option value="' . $subject->getId() . '">' . $subject->getSbjName() . '</option>';
        }

        return $this->json($options);
    }
}
