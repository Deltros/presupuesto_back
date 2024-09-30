<?php

namespace App\Controller;

use App\Service\GastoService;
use App\Repository\TarjetaRepository;
use App\Repository\GastoTipoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GastosController extends AbstractController
{
    private $gastoService;
    private $tarjetaRepository;

    public function __construct(
        GastoService $gastoService,
        TarjetaRepository $tarjetaRepository, 
        GastoTipoRepository $gastoTipoRepository)
    {
        $this->gastoService        = $gastoService;
        $this->tarjetaRepository   = $tarjetaRepository;
        $this->gastoTipoRepository = $gastoTipoRepository;
    }

    #[Route('/gastos/tipos', name: 'app_gastos_tipos')]
    public function getTipos(): JsonResponse
    {
        $tipos = $this->gastoTipoRepository->findAll();
    
        return $this->json($tipos);
    }

    #[Route('/gastos/añadir', name: 'app_gastos_añadir', methods: ['POST'])]
    public function addGasto(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $descripcion = $data['descripcion'] ?? null;
        $valor       = $data['valor'] ?? null;
        $tarjetaId   = $data['tarjeta_id'] ?? null;
        $fechaGasto  = $data['fecha_gasto'] ?? null;
        $tipoGastoId = $data['tipo_gasto_id'] ?? null;

        $fechaGasto = new \DateTime($fechaGasto);

        if (!$descripcion || !$valor || !$tarjetaId) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $tarjeta = $this->tarjetaRepository->find($tarjetaId);
        if (!$tarjeta) {
            return new JsonResponse(['error' => 'Tarjeta no encontrada'], 404);
        }

        $tipoGasto = $this->gastoTipoRepository->find($tipoGastoId);
        if (!$tipoGasto) {
            return new JsonResponse(['error' => 'Tipo de gasto no encontrado'], 404);
        }

        error_log("---------------------");
        error_log(print_r($tipoGasto, true));
        error_log("---------------------");
        $gasto = $this->gastoService->crearGasto(
            $descripcion, 
            $valor, 
            $tarjeta, 
            $fechaGasto,
            $tipoGasto);

        return new JsonResponse(['status' => 'Gasto creado exitosamente', 'gasto_id' => $gasto->getId()], 201);
    }

}
