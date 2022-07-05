<?php

namespace App\Entity\Traits;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

// class MUST implement @ORM\HasLifecycleCallbacks
trait TimestampableTrait {

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $updatedAt;

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface {
        return $this->updatedAt;
    }


    public function setUpdatedAt(\DateTimeInterface $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void {
        $this->updatedAt = new \DateTime('now');
        $this->createdAt = new \DateTime('now');
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void {
        $this->updatedAt = new \DateTime('now');
    }
}
