<?php

namespace App\Controller;

use App\Entity\Gasto;
use App\Entity\Tarjeta;
use App\Repository\GastoRepository;
use App\Repository\TarjetaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GastosController extends AbstractController
{
    private $gastoRepository;
    private $tarjetaRepository;
    private $entityManager;

    public function __construct(GastoRepository $gastoRepository, TarjetaRepository $tarjetaRepository, EntityManagerInterface $entityManager)
    {
        $this->gastoRepository = $gastoRepository;
        $this->tarjetaRepository = $tarjetaRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/gastos/tipos', name: 'app_gastos_tipos')]
    public function getTipos(): JsonResponse
    {
        $tipos = $this->testRepository->findAll();
    
        // Devuelve los datos serializados con el método json()
        return $this->json($tipos);
    }

    #[Route('/gastos/añadir', name: 'app_gastos_añadir', methods: ['POST'])]
    public function addGasto(Request $request): JsonResponse
    {
        // Obtener datos del cuerpo de la solicitud
        $data = json_decode($request->getContent(), true);

        $descripcion = $data['descripcion'] ?? null;
        $valor       = $data['valor'] ?? null;
        $tarjetaId   = $data['tarjeta_id'] ?? null;
        $fechaGasto  = $data['fecha_gasto'] ?? null;

        $fechaGasto = new \DateTime($fechaGasto);

        if (!$descripcion || !$valor || !$tarjetaId) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $tarjeta = $this->tarjetaRepository->find($tarjetaId);

        if (!$tarjeta) {
            return new JsonResponse(['error' => 'Tarjeta no encontrada'], 404);
        }

        $gasto = new Gasto();
        $gasto->setDescripcion($descripcion);
        $gasto->setValor($valor);
        $gasto->setTarjeta($tarjeta);
        $gasto->setFechaGasto($fechaGasto);

        $this->entityManager->persist($gasto);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Gasto creado exitosamente'], 201);
    }
}
