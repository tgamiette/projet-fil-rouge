<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DeliveryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DeliveryRepository::class)]
#[ApiResource(collectionOperations: ['GET', 'POST'], itemOperations: ['GET', 'PUT', 'DELETE'], normalizationContext: ['groups' => ['delivery_read']])]
class Delivery {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['delivery_read'])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'delivery', targetEntity: OrderSeller::class)]
    private $orderSellers;

    public function __construct() {
        $this->orderSellers = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|OrderSeller[]
     */
    public function getOrderSellers(): Collection {
        return $this->orderSellers;
    }

    public function addOrderSeller(OrderSeller $orderSeller): self {
        if (!$this->orderSellers->contains($orderSeller)) {
            $this->orderSellers[] = $orderSeller;
            $orderSeller->setDelivery($this);
        }

        return $this;
    }

    public function removeOrderSeller(OrderSeller $orderSeller): self {
        if ($this->orderSellers->removeElement($orderSeller)) {
            // set the owning side to null (unless already changed)
            if ($orderSeller->getDelivery() === $this) {
                $orderSeller->setDelivery(null);
            }
        }

        return $this;
    }

}
