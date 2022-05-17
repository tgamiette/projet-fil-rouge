<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\RefusePurchase;
use App\Controller\ValidatePurchase;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
//#[ApiResource(collectionOperations: ['GET','POST'], itemOperations: ['GET','PUT'])]
#[ApiResource(collectionOperations: ['GET'],
    itemOperations: [
        'GET',
        'validate' =>
            [
                'method' => 'POST',
                'path' => '/purchases/{id}/validate',
                'controller' => ValidatePurchase::class,
            ],
        'refuse' => [
            'method' => 'POST',
            'path' => '/purchase/{id}/refuse',
            'controller' => RefusePurchase::class,
        ],
    ],
)]
class Purchase {

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PAID = 'PAID';
    public const STATUS_ERROR = 'ERROR';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $stripeToken;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $status;

    #[ORM\ManyToOne(targetEntity: OrderUser::class, inversedBy: 'purchases')]
    private $orderUser;

    public function getId(): ?int {
        return $this->id;
    }

    public function getStripeToken(): ?string {
        return $this->stripeToken;
    }

    public function setStripeToken(string $stripeToken): self {
        $this->stripeToken = $stripeToken;

        return $this;
    }

    public function getStatus(): ?string {
        return $this->status;
    }

    public function setStatus(string $status): self {
        $this->status = $status;

        return $this;
    }

    public function getOrderUser(): ?OrderUser {
        return $this->orderUser;
    }

    public function setOrderUser(?OrderUser $orderUser): self {
        $this->orderUser = $orderUser;

        return $this;
    }
}
