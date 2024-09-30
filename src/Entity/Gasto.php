<?php

namespace App\Entity;

use App\Repository\GastoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GastoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Gasto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tarjeta::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tarjeta $tarjeta = null;

    #[ORM\ManyToOne(targetEntity: GastoTipo::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?GastoTipo $gastoTipo = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(type: 'integer')]
    private ?string $valor = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $fecha_gasto = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function geTarjeta(): ?Tarjeta
    {
        return $this->tarjeta;
    }

    public function setTarjeta(?Tarjeta $tarjeta): self
    {
        $this->tarjeta = $tarjeta;

        return $this;
    }

    public function geGastoTipo(): ?GastoTipo
    {
        return $this->gastoTipo;
    }

    public function setGastoTipo(?GastoTipo $gastoTipo): self
    {
        $this->gastoTipo = $gastoTipo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(int $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getFechaGasto(): ?\DateTimeInterface
    {
        return $this->fecha_gasto;
    }
    
    public function setFechaGasto(\DateTimeInterface $fecha_gasto): self
    {
        $this->fecha_gasto = $fecha_gasto;
    
        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTime();
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
}
