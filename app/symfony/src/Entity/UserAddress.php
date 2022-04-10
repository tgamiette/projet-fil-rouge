<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserAddressRepository::class)]
#[ApiResource(
    collectionOperations: ['GET', 'POST'],
    itemOperations: ['GET', 'PUT', 'DELETE'],
    denormalizationContext: ['disable_type_enforcement' => true]
)]
class UserAddress {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'string', length: 255)]
    private $adressLine1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $addresLine2;

    #[ORM\Column(type: 'string', length: 100)]
    private $city;

    #[ORM\Column(type: 'decimal', precision: 5, scale: '0')]
    private $postalCode;

    #[ORM\Column(type: 'string', length: 255)]
    private $country;

    #[ORM\Column(type: 'integer')]
    private $phoneNumber;

    public function getId(): ?int {
        return $this->id;
    }

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(User $user): self {
        $this->user = $user;

        return $this;
    }

    public function getAdressLine1(): ?string {
        return $this->adressLine1;
    }

    public function setAdressLine1(string $adressLine1): self {
        $this->adressLine1 = $adressLine1;

        return $this;
    }

    public function getAddresLine2(): ?string {
        return $this->addresLine2;
    }

    public function setAddresLine2(?string $addresLine2): self {
        $this->addresLine2 = $addresLine2;

        return $this;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(string $city): self {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string {
        return $this->country;
    }

    public function setCountry(string $country): self {
        $this->country = $country;

        return $this;
    }

    public function getPhoneNumber(): ?int {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
