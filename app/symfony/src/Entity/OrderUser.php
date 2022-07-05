<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\Constraints\OrderUserConstraint as AssertCustom;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: OrderUserRepository::class)]
#[ORM\Table(name: '`order_user`')]
#[ApiResource(collectionOperations: [
    'GET',
    'POST'
],
    itemOperations: ['GET', 'PUT'],
    attributes: [
        'order' => ['createdAt' => 'desc'],
        'pagination_client_enabled' => true,
        'pagination_items_per_page' => 20,
    ],
    denormalizationContext: ['disable_type_enforcement' => true],
    normalizationContext: ['groups' => ['orderUser_read']])]
//todo filter par status de commande
#[ApiFilter(RangeFilter::class, properties: ['total'])]
class OrderUser {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float', nullable: false)]
    #[Assert\Type(type: 'float', message: 'valeur incorrecte')]
    #[Groups(['orderUser_read', 'selfOrder_read'])]
    private $total;

    #[ORM\Column(type: 'json', nullable: true)]
    #[Groups(['orderUser_read'])]
    #[AssertCustom\MinimalProperties(options: [])]
    #[Assert\NotBlank()]
    private $products = [];

    #[ORM\OneToMany(mappedBy: 'orderUser', targetEntity: Purchase::class)]
    private $purchases;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: ProductsOrder::class)]
    #[Groups(['orderUser_read'])]
    private $productsOrders;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orderUsers')]
    private $buyer;

    use TimestampableTrait;

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

    /**
     * @return Collection<int, ProductsOrder>
     */
    public function getProductsOrders(): Collection {
        return $this->productsOrders;
    }

    public function addProductsOrder(ProductsOrder $productsOrder): self {
        if (!$this->productsOrders->contains($productsOrder)) {
            $this->productsOrders[] = $productsOrder;
            $productsOrder->setorder($this);
        }

        return $this;
    }

    public function removeProductsOrder(ProductsOrder $productsOrder): self {
        if ($this->productsOrders->removeElement($productsOrder)) {
            // set the owning side to null (unless already changed)
            if ($productsOrder->getorder() === $this) {
                $productsOrder->setorder(null);
            }
        }

        return $this;
    }

    public function getBuyer(): ?User {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): self {
        $this->buyer = $buyer;

        return $this;
    }
}
