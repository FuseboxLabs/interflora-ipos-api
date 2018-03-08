<?php


namespace Interflora\ipos\Entity;
/**
 * Class ExternalReference
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ApiResource(
 *   attributes={
 *     "normalization_context"={
 *       "groups"={"external_reference_get"}
 *     },
 *    "denormalization_context"={
 *       "groups"={"external_reference_set"}
 *     }
 *   }
 * )
 */
class ExternalReference
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"external_reference_get"})
     */
    protected $id;

    /**
     * @var Order
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="externalReferences")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *
     * @Groups({"external_reference_get", "external_reference_set"})
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
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"external_reference_get", "external_reference_set"})
     */
    protected $service;


    /**
     * @var string External order id
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="external_order_id", type="string", length=50)
     *
     * @Groups({"external_reference_get", "external_reference_set"})
     */
    protected $orderId;

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
     * @return ExternalReference
     */
    public function setId(int $id): ExternalReference
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     *
     * @return ExternalReference
     */
    public function setOrder(Order $order): ExternalReference
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     *
     * @return ExternalReference
     */
    public function setService(string $service): ExternalReference
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     *
     * @return ExternalReference
     */
    public function setOrderId(string $orderId): ExternalReference
    {
        $this->orderId = $orderId;

        return $this;
    }

}
