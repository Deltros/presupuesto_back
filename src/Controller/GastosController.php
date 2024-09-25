<?php

namespace App\Controller;

use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class GastosController extends AbstractController
{

    private $testRepository;

    public function __construct(TestRepository $testRepository)
    {
        $this->testRepository = $testRepository;
    }

    #[Route('/gastos', name: 'app_gastos')]
    public function index(): Response
    {
        return $this->render('gastos/index.html.twig', [
            'controller_name' => 'GastosController',
        ]);
    }

    #[Route('/gastos/tipos', name: 'app_gastos_tipos')]
    public function getTipos(): JsonResponse
    {
        $tipos = $this->testRepository->findAll();
    
        // Devuelve los datos serializados con el método json()
        return $this->json($tipos);
    }
}
