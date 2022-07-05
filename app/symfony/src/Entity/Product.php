<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\CreateMediaObjectAction;
use App\Controller\CreateProductAction;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[Uploadable]
#[ApiResource(
    collectionOperations: [
        'GET',
        'POST',
        'MANAGE' => [
            'pagination_enabled' => false,
            'pagination_client_enabled' => true,
            'path' => 'products/self',
            'method' => 'GET',
            "security_message" => "admin ou pas admin Tu n'es pas un vendeur donc va la bas",
//            'security' => "is_granted('ROLE_SELLER')",
//            'normalization_context' => ['groups' => '']
        ],
        'POST' => [
            'controller' => CreateProductAction::class,
//            'deserialize'=> false,
            'input_formats' => [
                'multipart' => ['multipart/form-data']
            ],
            "security_message" => "admin ou pas admin Tu n'es pas un vendeur donc va la bas",
//            "security" => "is_granted('ROLE_SELLER')"
        ]
    ],
    itemOperations: [
        'GET',
        'PUT' => [
            "security_message" => "Tu n'as pas les droits sur ce produit ",
            "security" => "is_granted('ROLE_ADMIN') and object.seller == user",
        ],
        'DELETE' => [
            "security_message" => "Tu n'as pas les droits sur ce produit ",
            "security" => "is_granted('ROLE_ADMIN') and object.seller == user",
        ]
    ],
    attributes: [
        'order' => ['price' => 'desc'],
        'pagination_enabled' => true,
        'pagination_items_per_page' => 20,
    ],
    denormalizationContext: [
        'disable_type_enforcement' => true,
        'groups' => ['products_write']
    ],
    normalizationContext: ["groups" => ["products_read"]],
)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial', 'category.title' => 'partial', 'category' => 'exact', 'seller' => 'exact'])]
class Product extends AbstractEntity {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['products_read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Titre obligatoire')]
    #[Groups(['users_read', 'products_read', 'orderUser_read', 'orderSeller_read', 'category_read', 'products_write'])]
    private $title;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Prix manquant')]
    #[Assert\Type(type: 'integer', message: 'type incorrecte {{ value }} pas {{ type }}')]
    #[Groups(['products_read', 'orderUser_read', 'products_write'])]
    private $price;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['products_read', 'category_read', 'products_write'])]
    private $description;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[Assert\Type(Category::class, message: 'object incorrect ?')]
    #[Assert\NotBlank(message: 'category obligatoire')]
    #[Groups(['products_read', 'products_write'])]
    public $category;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'quantité manquant')]
    #[Assert\Positive(message: 'Valeur positive??')]
    #[Assert\Type(type: 'integer', message: 'type incorrecte {{ value }} pas {{ type }}')]
    #[Groups(['products_read', 'products_write'])]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'products')]
    #[Assert\NotBlank(message: 'vendeur manquant')]
    #[Groups(['products_read'])]
    public $seller;

//    #[Groups(['products_read','products_write'])]
//    #[ORM\OneToOne(mappedBy: 'product', targetEntity: Objective::class, cascade: ['persist', 'remove'])]
//    private $objective;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductsOrder::class)]
    private $productsOrders;


//    #[ORM\ManyToOne(targetEntity: MediaObject::class)]
//    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['products_read'])]
    public ?string $contentUrl = null;

    /**
     * @Vich\UploadableField(mapping="products_object", fileNameProperty="filePath")
     */
    #[Groups(['products_write'])]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    #[ORM\Column(type: 'integer')]
    private $objective;


    public function __construct($array = null) {
        parent::__construct($array);
        $this->productsOrders = new ArrayCollection();
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

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price): self {
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

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity): self {
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

    public function getSeller() {
        return $this->seller;
    }

    public function setSeller(?User $seller): self {
        $this->seller = $seller;

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
            $productsOrder->setProduct($this);
        }

        return $this;
    }

    public function removeProductsOrder(ProductsOrder $productsOrder): self {
        if ($this->productsOrders->removeElement($productsOrder)) {
            // set the owning side to null (unless already changed)
            if ($productsOrder->getProduct() === $this) {
                $productsOrder->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MediaObject>
     */
    public function getimages(): Collection {
        return $this->images;
    }

    public function addimages(MediaObject $images): self {
        if (!$this->images->contains($images)) {
            $this->images[] = $images;
            $images->setProduct($this);
        }

        return $this;
    }

    public function removeimages(MediaObject $images): self {
        if ($this->images->removeElement($images)) {
            // set the owning side to null (unless already changed)
            if ($images->getProduct() === $this) {
                $images->setProduct(null);
            }
        }

        return $this;
    }

    public function getObjective(): ?int
    {
        return $this->objective;
    }

    public function setObjective(int $objective): self
    {
        $this->objective = $objective;

        return $this;
    }
}
