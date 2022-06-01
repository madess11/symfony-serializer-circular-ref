<?php

namespace App\Controller;

use App\Repository\CatalogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\GetSetMethodNormalizerContextBuilder;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(CatalogRepository $catalogRepository, SerializerInterface $serializer): JsonResponse
    {
        $catalogs = $catalogRepository->findAll();

        $circularRefHandler = fn($catalog, $format, $context)=> $catalog->getName();

        $context = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => $circularRefHandler
        ];

        $catalogsJson = $serializer->serialize($catalogs, 'json', $context);


        return $this->json([
            'message' => $catalogsJson
        ]);
    }
}
