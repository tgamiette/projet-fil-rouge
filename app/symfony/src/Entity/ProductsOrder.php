<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\ProductsOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProductsOrderRepository::class)]
class ProductsOrder extends AbstractEntity {
    public const STATUT_PENDING = 'PENDING';
    public const STATUT_PENDING_RETURN = 'PENDING_RETURN';
    public const STATUT_PAID = 'PAID';
    public const STATUT_RETURN = 'RETURN';
    public const STATUT_VALIDE = 'VALIDE';
    public const STATUT_REFUSE = 'REFUSE';

    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: OrderUser::class, inversedBy: 'productsOrders')]
    private $order;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'productsOrders')]
    private $product;

    #[ORM\Column(type: 'string')]
    private $status;

    #[ORM\Column(type: 'float')]
    private $quantity;

    #[ORM\Column(type: 'float')]
    private $prixU;

    #[ORM\Column(type: 'integer')]
    private $unit;

    #[ORM\Column(type: 'integer')]
    private $total;

    #[ORM\ManyToOne(targetEntity: OrderSeller::class, inversedBy: 'productsOrders')]
    private $orderSeller;

    public function getId(): ?int {
        return $this->id;
    }

    public function getOrder(): ?OrderUser {
        return $this->order;
    }

    public function setOrder(?OrderUser $order): self {
        $this->order = $order;

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

    public function setStatus(string $status): self {
        $this->status = $status;

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

    public function getOrderSeller(): ?OrderSeller
    {
        return $this->orderSeller;
    }

    public function setOrderSeller(?OrderSeller $orderSeller): self
    {
        $this->orderSeller = $orderSeller;

        return $this;
    }

}
