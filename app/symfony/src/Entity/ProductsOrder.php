<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Entity;

use App\Repository\ProductsOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsOrderRepository::class)]
class ProductsOrder extends AbstractEntity {
    public const STATUT_PENDING = 'PENDING';
    public const STATUT_PENDING_RETURN = 'PENDING_RETURN';
    public const STATUT_RETURN = 'RETURN';
    public const STATUT_VALIDE = 'VALID';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: OrderUser::class, inversedBy: 'productsOrders')]
    private $orderId;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'productsOrders')]
    private $product;

    #[ORM\Column(type: 'string')]
    private $status;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\Column(type: 'float')]
    private $quantity;

    #[ORM\Column(type: 'float')]
    private $prixU;

    #[ORM\Column(type: 'integer')]
    private $unit;

    #[ORM\Column(type: 'integer')]
    private $total;


    public function getId(): ?int {
        return $this->id;
    }

    public function getOrderId(): ?OrderUser {
        return $this->orderId;
    }

    public function setOrderId(?OrderUser $orderId): self {
        $this->orderId = $orderId;

        return $this;
    }

    public function getProduct(): ?Product {
        return $this->product;
    }

    public function setProduct(?Product $product): self {
        $this->product = $product;

        return $this;
    }

    public function getStatus(): ?int {
        return $this->status;
    }

    public function setStatus( $status): self {
        $this->status = $status;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getQuantity(): ?float {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrixU(): ?float {
        return $this->prixU;
    }

    public function setPrixU(float $prixU): self {
        $this->prixU = $prixU;

        return $this;
    }

    public function getUnit(): ?int {
        return $this->unit;
    }

    public function setUnit(int $unit): self {
        $this->unit = $unit;

        return $this;
    }

    public function getTotal(): ?int {
        return $this->total;
    }

    public function setTotal(int $total): self {
        $this->total = $total;

        return $this;
    }
}
