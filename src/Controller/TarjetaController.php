<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TarjetaRepository;


class TarjetaController extends AbstractController
{
    public function __construct(TarjetaRepository $tarjetaRepository)
    {
        $this->tarjetaRepository   = $tarjetaRepository;
    }

    #[Route('/tarjeta/getAll', name: 'app_tarjeta')]
    public function getAll(): Response
    {
        $tarjetas = $this->tarjetaRepository->findAll();
    
        return $this->json($tarjetas);
    }
}
