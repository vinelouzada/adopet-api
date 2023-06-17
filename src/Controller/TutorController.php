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
    public function __construct(private TutorRepository $tutorRepository)
    {}

    #[Route('/tutors', name: 'app_tutor', methods: ['GET'])]
    public function all(): JsonResponse
    {
        return $this->json(
            $this->tutorRepository->findAll(),200);
    }

    #[Route('/tutor', name: "app_save_tutor", methods:['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = $request->toArray();

        $tutor = new Tutor();
        $tutor->setName($data['name']);
        $tutor->setPhone($data['phone']);
        $tutor->setCity($data['city']);
        $tutor->setAbout($data['about']);
        $tutor->setPhoto($data['photo']);

        $this->tutorRepository->save($tutor,true);

        return $this->json([
            "name" => $tutor->getName(),
            "phone" => $tutor->getPhone(),
            "city" => $tutor->getCity(),
            "about" => $tutor->getAbout(),
            "photo" => $tutor->getPhoto()
        ],200);
    }

    #[Route('tutor/{id}', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $tutor = $this->tutorRepository->find($id);

        if ($tutor === null){
            return $this->json(["message" => "Tutor Not Found"], 200
            );
        }

        return $this->json($tutor, 200);
    }

    #[Route('tutor/delete/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {

        $tutor = $this->tutorRepository->find($id);

        if ($tutor === null){
            return $this->json(["message" => "Tutor does not exist"], 200);
        }

        $this->tutorRepository->remove($tutor, true);
        return $this->json(["message" => "Tutor was deleted"], 200);

    }

    #[Route("tutor/update/{id}", methods:['PATCH'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $tutor = $this->tutorRepository->find($id);

        if ($tutor === null){
            return $this->json(['message' => "Tutor does not exist"], 200);
        }

        $data = $request->toArray();


        $this->tutorRepository->update($tutor, $data, true);

        return $this->json([
            "name" => $tutor->getName(),
            "phone" => $tutor->getPhone(),
            "city" => $tutor->getCity(),
            "about" => $tutor->getAbout(),
            "photo" => $tutor->getPhoto()
        ],200);
    }

    #[Route("tutor/update/{id}", methods: ['PUT'])]
    public function updateAll(Request $request, int $id): JsonResponse
    {
        $tutor = $this->tutorRepository->find($id);

        if ($tutor === null){
            return $this->json(['message' => "Tutor does not exist"], 200);
        }

        $data = $request->toArray();

        $this->tutorRepository->updateAll($tutor, $data, true);


        return $this->json([
            "name" => $tutor->getName(),
            "phone" => $tutor->getPhone(),
            "city" => $tutor->getCity(),
            "about" => $tutor->getAbout(),
            "photo" => $tutor->getPhoto()
        ],200);
    }
}
