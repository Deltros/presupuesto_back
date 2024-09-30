<?php

namespace App\Service;

use App\Entity\Gasto;
use App\Entity\GastoTipo;
use App\Entity\Tarjeta;
use Doctrine\ORM\EntityManagerInterface;

class GastoService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function crearGasto(string $descripcion, int $valor, Tarjeta $tarjeta, \DateTime $fechaGasto, GastoTipo $tipoGasto): Gasto
    {
        $gasto = new Gasto();
        $gasto->setDescripcion($descripcion);
        $gasto->setValor($valor);
        $gasto->setTarjeta($tarjeta);
        $gasto->setFechaGasto($fechaGasto);
        $gasto->setGastoTipo($tipoGasto);

        $this->entityManager->persist($gasto);
        $this->entityManager->flush();

        return $gasto;
    }
}
