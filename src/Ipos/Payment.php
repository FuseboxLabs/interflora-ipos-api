<?php

namespace Interflora\Ipos;
/**
 * Class Payment
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ApiResource(
 *   attributes={
 *     "normalization_context"={
 *       "groups"={"payment_get"}
 *     },
 *    "denormalization_context"={
 *       "groups"={"payment_set"}
 *     }
 *   }
 * )
 */
class Payment
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"payment_get"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"payment_get", "payment_set"})
     */
    protected $method;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"payment_get", "payment_set"})
     */
    protected $transactionId;

    /**
     * @var Price
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="App\Entity\Price", cascade={"persist"}, orphanRemoval=true)
     * @JoinColumn(name="price", referencedColumnName="id")
     *
     *
     * @Groups({"payment_get", "payment_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Price",
     *             "example"="/api/prices/1"
     *         }
     *     }
     * )
     */
    protected $price;

    /**
     * @var Order
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="payments")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *
     *
     * @Groups({"payment_get", "payment_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Order",
     *             "example"="/api/orders/1"
     *         }
     *     }
     * )
     */
    protected $order;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="json")
     *
     * @Groups({"payment_get", "payment_set"})
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
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @param Price $price
     *
     * @return Payment
     */
    public function setPrice(Price $price): Payment
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
