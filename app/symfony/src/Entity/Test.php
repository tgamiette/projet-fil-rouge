<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
        "post" => [
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "Only admins can add books.",
        ],
    ], itemOperations: [
    'get' => ['security' => "is_granted('TEST_READ',object)"]
])]
class Test {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tests')]
    private $owner;

    #[ORM\Column(type: 'string', length: 255,nullable: false)]
    private $name;

    public function getId(): ?int {
        return $this->id;
    }

    public function getOwner(): ?User {
        return $this->owner;
    }

    public function setOwner(?User $owner): self {
        $this->owner = $owner;

        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }
}
