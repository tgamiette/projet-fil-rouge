<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    collectionOperations: ['GET', 'POST'],
    itemOperations: ['GET', 'PUT', 'DELETE'],
    denormalizationContext: ['disable_type_enforcement' => true], normalizationContext: ["groups" => ['users_read']]
)]
#[UniqueEntity("email", "Un Utilisateur existe déja avec cet email")]
class User implements UserInterface, PasswordAuthenticatedUserInterface {
    #[ORM\Id]
    #[Groups(['users_read'])]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Email obligatoire')]
    #[Assert\Email(message: "Email invalide")]
    #[Groups(['orderUser_read', 'users_read', 'products_read'])]
    private $email;


    #[ORM\Column(type: 'json')]
    #[Groups(['users_read'])]
    private $roles = [];

    #[Assert\NotBlank(message: 'Mot de passe requit')]
//    #[Assert\Type(type: "string", message: 'Mo')]
//    #[Groups()]
    #[ORM\Column(type: 'string')]
    private $password;

    #[Assert\NotBlank(message: 'Mot de passe requit')]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['orderUser_read', 'users_read', 'products_read'])]
    private $fullName;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserPayment::class, orphanRemoval: true)]
    #[Groups(['users_read'])]
    private $userPayments;


    #[ORM\OneToMany(mappedBy: 'seller', targetEntity: Product::class)]
    #[Groups(['users_read'])]
    private $products;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserInfo::class, cascade: ['persist', 'remove'])]
    private $userInfo;

    public function __construct() {
        $this->userPayments = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullName(): ?string {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return Collection|UserPayment[]
     */
    public function getUserPayments(): Collection {
        return $this->userPayments;
    }

    public function addUserPayment(UserPayment $userPayment): self {
        if (!$this->userPayments->contains($userPayment)) {
            $this->userPayments[] = $userPayment;
            $userPayment->setUser($this);
        }

        return $this;
    }

    public function removeUserPayment(UserPayment $userPayment): self {
        if ($this->userPayments->removeElement($userPayment)) {
            // set the owning side to null (unless already changed)
            if ($userPayment->getUser() === $this) {
                $userPayment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts() {
        return $this->products;
    }

    public function addProduct(Product $product): self {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSeller($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSeller() === $this) {
                $product->setSeller(null);
            }
        }

        return $this;
    }

    public function getUsername(): string {
        return $this->email;
    }

    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    public function setUserInfo(?UserInfo $userInfo): self
    {
        // unset the owning side of the relation if necessary
        if ($userInfo === null && $this->userInfo !== null) {
            $this->userInfo->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($userInfo !== null && $userInfo->getUser() !== $this) {
            $userInfo->setUser($this);
        }

        $this->userInfo = $userInfo;

        return $this;
    }

}
