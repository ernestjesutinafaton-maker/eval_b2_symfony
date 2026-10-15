<?php

namespace App\Entity;

use App\Enum\Category;
use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    private ?string $titre = null;

    // NotNull suffit pour une date : le formulaire convertit déjà la saisie en objet DateTime.
    // Réf. : https://symfony.com/doc/7.4/reference/constraints/NotNull.html
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: 'La date est obligatoire.')]
    private ?\DateTime $date = null;

    // Colonne non nullable : le sujet impose ce champ.
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Les informations sont obligatoires.')]
    private ?string $informations = null;

   // Réf. : https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/basic-mapping.html
    
    #[ORM\Column(enumType: Category::class)]
    #[Assert\NotNull(message: 'Choisissez une catégorie.')]
    private ?Category $category = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le nombre de places est obligatoire.')]
    #[Assert\Positive(message: 'Le nombre de places doit être supérieur à 0.')]
    private ?int $nombreDePlaces = null;

    // On stocke uniquement le NOM du fichier ; nullable car il n'existe qu'après l'upload.
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    // Valeur par défaut false = "Non validé" à la création (point 3 du sujet).
    #[ORM\Column]
    private bool $validated = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(string $informations): static
    {
        $this->informations = $informations;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getNombreDePlaces(): ?int
    {
        return $this->nombreDePlaces;
    }

    public function setNombreDePlaces(int $nombreDePlaces): static
    {
        $this->nombreDePlaces = $nombreDePlaces;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    // Convention "is..." pour un booléen : utilisable en Twig avec event.validated.
    public function isValidated(): bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): static
    {
        $this->validated = $validated;

        return $this;
    }
    // ... dans la classe Event :

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }
}