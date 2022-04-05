<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DeliveryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(collectionOperations: ['GET','POST'], itemOperations: ['GET','PUT','DELETE'])]
#[ORM\Entity(repositoryClass: DeliveryRepository::class)]
class Delivery {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(['products_read'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'Delivery', targetEntity: Product::class)]
    private $products;

    public function __construct() {
        $this->products = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection {
        return $this->products;
    }

    public function addProduct(Product $product): self {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setDelivery($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getDelivery() === $this) {
                $product->setDelivery(null);
            }
        }

        return $this;
    }
}
