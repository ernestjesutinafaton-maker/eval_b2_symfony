<?php

namespace App\Entity;

use App\Enum\Category;
use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column]
    private ?\DateTime $Date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Informations = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: Category::class)]
    private array $Catégories = [];

    #[ORM\Column]
    private ?int $Nombre_de_places = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Image = null;

    #[ORM\Column]
    private ?bool $Statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->Date;
    }

    public function setDate(\DateTime $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getInformations(): ?string
    {
        return $this->Informations;
    }

    public function setInformations(?string $Informations): static
    {
        $this->Informations = $Informations;

        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCatégories(): array
    {
        return $this->Catégories;
    }

    public function setCatégories(array $Catégories): static
    {
        $this->Catégories = $Catégories;

        return $this;
    }

    public function getNombreDePlaces(): ?int
    {
        return $this->Nombre_de_places;
    }

    public function setNombreDePlaces(int $Nombre_de_places): static
    {
        $this->Nombre_de_places = $Nombre_de_places;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->Statut;
    }

    public function setStatut(bool $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }
}
