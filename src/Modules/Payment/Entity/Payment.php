<?php

declare(strict_types=1);

namespace App\Modules\Payment\Entity;

use App\Modules\Order\Entity\Order;
use App\Modules\Payment\Enums\PayType;
use App\Modules\Payment\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: PaymentType::NAME, length: 255)]
    private ?PayType $type = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $orderEntity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?PayType
    {
        return $this->type;
    }

    public function setType(?PayType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getOrderEntity(): ?Order
    {
        return $this->orderEntity;
    }

    public function setOrderEntity(?Order $orderEntity): static
    {
        $this->orderEntity = $orderEntity;

        return $this;
    }
}
