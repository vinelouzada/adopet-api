<?php

namespace App\Controller;

use App\Entity\Tutor;
use App\Repository\TutorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TutorController extends AbstractController
{
    #[Route('/tutors', name: 'app_tutor', methods: ['GET'])]
    public function index(TutorRepository $tutorRepository): JsonResponse
    {
        return $this->json(
            $tutorRepository->findAll()
        ,200);
    }

    #[Route('/tutor', name: "app_save_tutor", methods:['POST'])]
    public function create(Request $request, TutorRepository $tutorRepository)
    {
        $data = $request->toArray();

        $tutor = new Tutor();
        $tutor->setName($data['name']);
        $tutor->setPhone($data['phone']);
        $tutor->setCity($data['city']);
        $tutor->setAbout($data['about']);
        $tutor->setPhoto($data['photo']);

        $tutorRepository->save($tutor,true);

        return $this->json([
            "name" => $tutor->getName(),
            "phone" => $tutor->getPhone(),
            "city" => $tutor->getCity(),
            "about" => $tutor->getAbout(),
            "photo" => $tutor->getPhoto()
        ],200);
    }
}
