<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderSellerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderSellerRepository::class)]
#[ApiResource(collectionOperations: ['GET', 'POST'],
    itemOperations: ['GET', 'PUT', 'DELETE'],
    attributes: [
        'order' => ['createdAt' => 'desc'],
        'pagination_enabled' => true,
        'pagination_items_per_page' => 5
    ],
    denormalizationContext: ['disable_type_enforcement' => true],
    normalizationContext: ['groups' => ['orderSeller_read']]
)]
class OrderSeller {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(['orderSeller_read'])]
    #[Assert\NotBlank(message: 'Quantité obligatoire')]
    #[Assert\Positive(message: "La quantité doit être positive")]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[Assert\NotBlank(message: 'Produit obligatoire')]
    #[Groups(['orderSeller_read'])]
    private $product;

    #[ORM\ManyToOne(targetEntity: Delivery::class, inversedBy: 'order_sellers')]
    #[Groups(['orderSeller_read'])]
    private $delivery;

    #[ORM\Column(type: 'float')]
    #[Assert\NotBlank(message: 'Total obligatoire')]
    #[Assert\Positive(message: "Le Total doit être positive")]
    #[Groups(['orderSeller_read'])]
    private $total;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotBlank(message: 'Date manquante')]
    #[Assert\DateTime(message: 'la date doit être auformat YYY/MM/DD (hh:min:sec)')]
    #[Groups(['orderSeller_read'])]
    private $createdAt;

    public function getId(): ?int {
        return $this->id;
    }

    public function getQuantity(): ?float {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): ?Product {
        return $this->product;
    }

    public function setProduct(?Product $product): self {
        $this->product = $product;

        return $this;
    }

    public function getDelivery(): ?Delivery {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): self {
        $this->delivery = $delivery;

        return $this;
    }

    public function getTotal(): ?float {
        return $this->total;
    }

    public function setTotal($total): self {
        $this->total = $total;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }
}
