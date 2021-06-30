<?php

namespace App\Controller;

use App\Repository\DeveloperRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DeveloperController extends AbstractController
{
    /**
     * @Route("/developer", name="developer")
     */
    public function index(DeveloperRepository $developerRepository): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, $encoders);
        $data = $serializer->normalize($developerRepository->getAllDevelopers(), null,[AbstractNormalizer::ATTRIBUTES=>[
            "name","difficultly","time","tasks"=>["title","estimatedDuration","level"]
        ]]);
        return $this->json([
            "success" => true,
            "data" => $data
        ]);
    }
}
