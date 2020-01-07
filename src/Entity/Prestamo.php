<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrestamoRepository")
 */
class Prestamo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    private $prestamo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Material", mappedBy="prestamo")
     */
    private $material;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $entregado;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Biblioteca")
     * @ORM\JoinColumn(nullable=false)
     */
    private $biblioteca;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Persona", mappedBy="prestamo")
     */
    private $persona;

    public function __construct()
    {
        $this->material = new ArrayCollection();
        $this->persona = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrestamo(): ?int
    {
        return $this->prestamo;
    }

    public function setPrestamo(int $prestamo): self
    {
        $this->prestamo = $prestamo;

        return $this;
    }

    /**
     * @return Collection|Material[]
     */
    public function getMaterial(): Collection
    {
        return $this->material;
    }

    public function addMaterial(Material $material): self
    {
        if (!$this->material->contains($material)) {
            $this->material[] = $material;
            $material->setPrestamo($this);
        }

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        if ($this->material->contains($material)) {
            $this->material->removeElement($material);
            // set the owning side to null (unless already changed)
            if ($material->getprestamo() === $this) {
                $material->setprestamo(null);
            }
        }

        return $this;
    }

    public function getEntregado(): ?bool
    {
        return $this->entregado;
    }

    public function setEntregado(?bool $entregado): self
    {
        $this->entregado = $entregado;

        return $this;
    }

    public function getBiblioteca(): ?Biblioteca
    {
        return $this->biblioteca;
    }

    public function setBiblioteca(?Biblioteca $biblioteca): self
    {
        $this->biblioteca = $biblioteca;

        return $this;
    }
}
