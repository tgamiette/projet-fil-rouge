<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\Constraints as AssertCustom; // A custom constraint
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderUserRepository::class)]
#[ORM\Table(name: '`order_user`')]
#[ApiResource(collectionOperations: ['GET', 'POST'],
    itemOperations: ['GET', 'PUT'],
    attributes: ['order' => ['createdAt' => 'desc']],
    denormalizationContext: ['disable_type_enforcement' => true],
    normalizationContext: ['groups' => ['orderUser_read']])]
class OrderUser {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float',nullable: true)]
    #[Assert\NotBlank(message: 'Total obligatoire')]
    #[Assert\Type(type: 'integer', message: 'valeur incorrecte')]
    #[Groups(['orderUser_read'])]
    private $total;

    #[ORM\ManyToOne(targetEntity: OrderSeller::class)]
    #[Groups(['orderUser_read'])]
    private $orderSeller;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['orderUser_read'])]
    private $customer;

    #[ORM\Column(type: 'json', nullable: true)]
    #[Groups(['orderUser_read'])]
    #[AssertCustom\OrderUserConstraint\MinimalProperties()]
    #[Assert\NotBlank()]
    private $products = [];

    #[ORM\OneToMany(mappedBy: 'orderUser', targetEntity: Purchase::class)]
    private $purchases;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\OneToMany(mappedBy: 'orderId', targetEntity: ProductsOrder::class)]
    #[Groups(['orderUser_read'])]
    private $productsOrders;

    public function __construct() {
        $this->purchases = new ArrayCollection();
        $this->productsOrders = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTotal(): ?float {
        return $this->total;
    }

    public function setTotal($total): self {
        $this->total = $total;

        return $this;
    }

    public function getOrderSeller(): ?OrderSeller {
        return $this->orderSeller;
    }

    public function setOrderSeller(?OrderSeller $orderSeller): self {
        $this->orderSeller = $orderSeller;

        return $this;
    }

    public function getCustomer(): ?User {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self {
        $this->customer = $customer;

        return $this;
    }

    public function getProducts(): ?array {
        return $this->products;
    }

    public function setProducts(?array $products): self {
        $this->products = $products;

        return $this;
    }

    /**
     * @return Collection<int, Purchase>
     */
    public function getPurchases(): Collection {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setOrderUser($this);
        }
        return $this;
    }

    public function removePurchase(Purchase $purchase): self {
        if ($this->purchase->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getOrderUser() === $this) {
                $purchase->setOrderUser(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, ProductsOrder>
     */
    public function getProductsOrders(): Collection
    {
        return $this->productsOrders;
    }

    public function addProductsOrder(ProductsOrder $productsOrder): self
    {
        if (!$this->productsOrders->contains($productsOrder)) {
            $this->productsOrders[] = $productsOrder;
            $productsOrder->setOrderId($this);
        }

        return $this;
    }

    public function removeProductsOrder(ProductsOrder $productsOrder): self
    {
        if ($this->productsOrders->removeElement($productsOrder)) {
            // set the owning side to null (unless already changed)
            if ($productsOrder->getOrderId() === $this) {
                $productsOrder->setOrderId(null);
            }
        }

        return $this;
    }
}
