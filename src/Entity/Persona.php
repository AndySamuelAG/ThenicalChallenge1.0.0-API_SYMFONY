<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonaRepository")
 */
class Persona
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $correo;

    /**
     * @ORM\Column(type="integer")
     */
    private $telefono;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $libros;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $adeudo;

    /**
     * @ORM\Column(type="integer")
     */
    private $numPersona;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Biblioteca")
     * @ORM\JoinColumn(nullable=false)
     */
    private $biblioteca;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $apellido;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prestamo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getLibros(): ?int
    {
        return $this->libros;
    }

    public function setLibros(?int $libros): self
    {
        $this->libros = $libros;

        return $this;
    }

    public function getAdeudo(): ?float
    {
        return $this->adeudo;
    }

    public function setAdeudo(?float $adeudo): self
    {
        $this->adeudo = $adeudo;

        return $this;
    }

    public function getNumPersona(): ?int
    {
        return $this->numPersona;
    }

    public function setNumPersona(int $numPersona): self
    {
        $this->numPersona = $numPersona;

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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getPrestamo(): ?int
    {
        return $this->prestamo;
    }

    public function setPrestamo(?int $prestamo): self
    {
        $this->prestamo = $prestamo;

        return $this;
    }
}
