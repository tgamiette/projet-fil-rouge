<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[ApiResource]
class Products {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    private $category;

    public function getId(): ?int {
        return $this->id;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(float $price): self {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category {
        return $this->category;
    }

    public function setCategory(?Category $category): self {
        $this->category = $category;

        return $this;
    }
}
