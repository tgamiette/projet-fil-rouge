<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderUserRepository::class)]
#[ORM\Table(name: '`order_user`')]
#[ApiResource(collectionOperations: ['GET', 'POST'],
    itemOperations: ['GET', 'PUT', 'DELETE'],
    attributes: ['order' => ['date' => 'desc']],
    denormalizationContext: ['disable_type_enforcement' => true],
    normalizationContext: ['groups' => ['orderUser_read']])]
class OrderUser {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Assert\NotBlank(message: 'Total obligatoire')]
    #[Assert\Type(type: 'integer', message: 'valeur incorrecte')]
    #[Groups(['orderUser_read'])]
    private $total;

    #[ORM\Column(type: 'date')]
    #[Groups(['orderUser_read'])]
    private $date;

//    #[ORM\JoinColumn(nullable: false)]
//    #[Groups(['orderUser_read'])]
//    #[ORM\Column(type: 'json')]
//    private $product;

    #[ORM\ManyToOne(targetEntity: OrderSeller::class)]
    #[Groups(['orderUser_read'])]
    private $orderSeller;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['orderUser_read'])]
    private $customer;

    #[ORM\Column(type: 'json', nullable: true)]
    #[Groups(['orderUser_read'])]
    private $products = [];

    #[ORM\OneToMany(mappedBy: 'orderUser', targetEntity: Purchase::class)]
    private $purchases;

    public function __construct() {
        $this->purchases = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self {
        $this->date = $date;

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
}
