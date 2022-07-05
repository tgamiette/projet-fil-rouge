<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderSellerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: OrderSellerRepository::class)]
//#[ApiResource(collectionOperations: ['GET', 'POST'],
//    itemOperations: ['GET', 'PUT', 'DELETE'],
//    attributes: [
//        'order' => ['createdAt' => 'desc'],
//        'pagination_enabled' => true,
//        'pagination_items_per_page' => 5
//    ],
//    denormalizationContext: ['disable_type_enforcement' => true],
//    normalizationContext: ['groups' => ['orderSeller_read']]
//)]
class OrderSeller {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(['orderSeller_read'])]
    #[Assert\NotBlank(message: 'Quantité obligatoire')]
    #[Assert\Positive(message: "La quantité doit être positive")]
    private ?float $quantity;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[Assert\NotBlank(message: 'Produit obligatoire')]
    #[Groups(['orderSeller_read'])]
    private ?Product $product;


    #[ORM\Column(type: 'float',nullable: true)]
    #[Assert\NotBlank(message: 'Total obligatoire')]
    #[Assert\Positive(message: "Le Total doit être positive")]
    #[Groups(['orderSeller_read'])]
    private ?float $total;

    #[ORM\OneToOne(targetEntity: Delivery::class, cascade: ['persist', 'remove'])]
    #[Groups(['orderSeller_read'])]
    private ?Delivery $delivery;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orderSellers')]
    #[ORM\JoinColumn(nullable: false)]
    private $seller;

    #[ORM\OneToMany(mappedBy: 'orderSeller', targetEntity: ProductsOrder::class)]
    private $productsOrders;

    public function __construct()
    {
        $this->productsOrders = new ArrayCollection();
    }

    use TimestampableTrait;

    public function getId(): ?int {
        return $this->id;
    }

    public function getQuantity(): ?float {
        return $this->quantity;
    }

    public function setQuantity( $quantity): self {
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

    public function getSeller(): ?User
    {
        return $this->seller;
    }

    public function setSeller(?User $user): self
    {
        $this->seller = $user;

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
            $productsOrder->setOrderSeller($this);
        }

        return $this;
    }

    public function removeProductsOrder(ProductsOrder $productsOrder): self
    {
        if ($this->productsOrders->removeElement($productsOrder)) {
            // set the owning side to null (unless already changed)
            if ($productsOrder->getOrderSeller() === $this) {
                $productsOrder->setOrderSeller(null);
            }
        }

        return $this;
    }
}
