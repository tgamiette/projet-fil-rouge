<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[ApiResource(attributes: [
    'order' => ['price' => 'desc'],
    'pagination_enabled' => true,
    'pagination_items_per_page' => 20

], normalizationContext: ["groups" => ["products_read"]])]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial', 'category.title' => 'partial'])]
class Product {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['products_read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['products_read'])]
    private $title;

    #[ORM\Column(type: 'float')]
    #[Groups(['products_read'])]
    private $price;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['products_read'])]
    private $description;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[Groups(['products_read'])]
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
