<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackJetonsRepository")
 */
class PackJetons
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
    private $nbJetons;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJetons(): ?int
    {
        return $this->nbJetons;
    }

    public function setNbJetons(int $nbJetons): self
    {
        $this->nbJetons = $nbJetons;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
