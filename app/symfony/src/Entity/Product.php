<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[ApiResource(collectionOperations: ['GET', 'POST'], itemOperations: ['GET', 'PUT', 'DELETE'], attributes: [
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

    #[ORM\Column(type: 'float')]
    private $quantity;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'product')]
    #[Groups(['products_read'])]
    private $seller;

    #[ORM\OneToOne(mappedBy: 'product', targetEntity: Objective::class, cascade: ['persist', 'remove'])]
    private $objective;

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

    public function getQuantity(): ?float {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self {
        $this->quantity = $quantity;

        return $this;
    }

    public function getImage(): ?string {
        return $this->image;
    }

    public function setImage(?string $image): self {
        $this->image = $image;

        return $this;
    }

    public function getSeller(): ?User {
        return $this->seller;
    }

    public function setSeller(?User $seller): self {
        $this->seller = $seller;

        return $this;
    }

    public function getObjective(): ?Objective {
        return $this->objective;
    }

    public function setObjective(Objective $objective): self {
        // set the owning side of the relation if necessary
        if ($objective->getProduct() !== $this) {
            $objective->setProduct($this);
        }

        $this->objective = $objective;

        return $this;
    }
}
