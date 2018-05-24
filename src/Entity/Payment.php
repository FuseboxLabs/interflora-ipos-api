<?php

namespace Interflora\IposApi\Entity;

use Interflora\IposApi\Constant\PaymentStatus;

/**
 * Class Payment
 */
class Payment
{

    /**
     * Payment capture statuses.
     */
    public const PAYMENT_CAPTURE_STATUS = [
        PaymentStatus::NEW,
        PaymentStatus::COMPLETED,
        PaymentStatus::ERROR,
    ];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $status = PaymentStatus::NEW;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $transactionId;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var string
     */
    protected $data;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Payment
     */
    public function setId(int $id): Payment
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Payment
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return Payment
     */
    public function setMethod(string $method): Payment
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransaction(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $recipient
     *
     * @return Payment
     */
    public function setTransaction(string $transactionId): Payment
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return Payment
     */
    public function setPrice($price): Payment
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @param Order $order
     *
     * @return Payment
     */
    public function setOrder(Order $order): Payment
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
      return $this->data;
    }

    /**
     * @param string $data
     *
     * @return Payment
     */
    public function setData(string $data): Payment
    {
      $this->data = $data;

      return $this;
    }

}
