<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Animales
 *
 * @ORM\Table(name="animales")
 * @ORM\Entity
 */
class Animal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tipo", type="string", length=200, nullable=true)
     */
    private $tipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color", type="string", length=200, nullable=true)
     */
    private $color;

    /**
     * @var string|null
     *
     * @ORM\Column(name="raza", type="string", length=255, nullable=true)
     */
    private $raza;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="animales")
     */
    private $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getRaza(): ?string
    {
        return $this->raza;
    }

    public function setRaza(?string $raza): self
    {
        $this->raza = $raza;

        return $this;
    }


}
