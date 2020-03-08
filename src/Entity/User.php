<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="string", length=200, unique=true)
     * @Assert\Email
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(?string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Animal", mappedBy="user")
     */
    private $animal;

    public function __construct()
    {
        $this->animal = new ArrayCollection();
    }

    /**
     * @return Collection|Animal[]
     */
    public function getProducts(): Collection
    {
        return $this->animal;
    }

    // addProduct() and removeProduct() were also added
}

