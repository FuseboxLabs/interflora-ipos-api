<?php
namespace Interflora\Ipos;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * Class Order
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ORM\Table(name="orders")
 * @ApiResource(
 *   itemOperations={
 *     "get"={"method"="GET", "path"="/orders/{id}"},
 *     "put"={"method"="PUT", "path"="/orders/{id}"},
 *     "delete"={"method"="DELETE", "path"="/orders/{id}"},
 *     "custom_post"={"route_name"="order_special_post", "description"="Creates
 *     a Order resource from json with related entities."}
 *   },
 *   attributes={
 *     "normalization_context"={
 *       "groups"={"order_get"}
 *     },
 *    "denormalization_context"={
 *       "groups"={"order_set"}
 *     },
 *    "filters"={
 *       "order.search_filter",
 *       "order.range_filter",
 *       "order.date_filter",
 *       "order.boolean_filter",
 *       "order.numeric_filter",
 *       "order.order_filter",
 *    }
 *   }
 * )
 */
class Order
{

    /**
     * Order type national
     */
    public const ORDER_TYPE_NATIONAL = 'NAT';

    /**
     * Order type international
     */
    public const ORDER_TYPE_INTERNATIONAL = 'INT';

    /**
     * Order status new
     */
    public const ORDER_STATUS_NEW = 'NEW';

    /**
     * Order status printed
     */
    public const ORDER_STATUS_PRINTED = 'PRINTED';

    /**
     * Order status not printed
     */
    public const ORDER_STATUS_NOT_PRINTED = 'NOT_PRINTED';

    /**
     * Order status delivered
     */
    public const ORDER_STATUS_DELIVERED = 'DELIVERED';

    /**
     * Order status canceled
     */
    public const ORDER_STATUS_CANCELED = 'CANCELED';

    /**
     * Order status completed
     */
    public const ORDER_STATUS_COMPLETED = 'COMPLETED';

    /**
     * International order status pending approval
     */
    public const ORDER_STATUS_PENDING_APPROVAL = 'PENDING_APPROVAL';

    /**
     * International order status outgoing
     */
    public const ORDER_STATUS_OUTGOING = 'OUTGOING';

    /**
     * International order status sent to florist gate
     */
    public const ORDER_STATUS_SENT = 'SENT';


    /**
     * National orders statuses
     */
    public const NATIONAL_ORDER_STATUSES = [
      self::ORDER_STATUS_NEW,
      self::ORDER_STATUS_NOT_PRINTED,
      self::ORDER_STATUS_PRINTED,
      self::ORDER_STATUS_DELIVERED,
      self::ORDER_STATUS_CANCELED,
      self::ORDER_STATUS_COMPLETED,
    ];

    /**
     * International order statuses
     */
    public const INTERNATIONAL_ORDER_STATUSES = [
      self::ORDER_STATUS_NEW,
      self::ORDER_STATUS_PENDING_APPROVAL,
      self::ORDER_STATUS_OUTGOING,
      self::ORDER_STATUS_SENT,
      self::ORDER_STATUS_COMPLETED,
    ];

    /**
     * Order types
     */
    public const ORDER_TYPES = [
      self::ORDER_TYPE_NATIONAL,
      self::ORDER_TYPE_INTERNATIONAL,
    ];

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     *
     * @Groups({"order_get"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=30)
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $orderId;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=20)
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "enum"={"NAT", "INT"},
     *             "example"="NAT"
     *         }
     *     }
     * )
     */
    protected $orderType = self::ORDER_TYPE_NATIONAL;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=20)
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "enum"={"NEW", "PRINTED", "DELIVERED"},
     *             "example"="NEW"
     *         }
     *     }
     * )
     */
    protected $status = self::ORDER_STATUS_NEW;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $fromCountry;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $toCountry;

    /**
     * @var \DateTime
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="datetime")
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $deliveryDate;

    /**
     * @var ExternalReference[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\ExternalReference", mappedBy="order",
     *                                                             cascade={"persist"},
     *                                                             orphanRemoval=true)
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="ExternalReference[]",
     *             "example"="/api/external_references/1"
     *         }
     *     }
     * )
     */
    protected $externalReferences;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $sendingMember;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $orderRemarks;

    /**
     * @var \DateTime
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="datetime")
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $orderDate;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $leaveAtDoor = false;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $leaveAtNeighbour = false;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $confirmSMS = false;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $confirmMail = false;

    /**
     * @var Price
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="App\Entity\Price", cascade={"persist"},
     *                                                orphanRemoval=true)
     * @JoinColumn(name="order_total", referencedColumnName="id")
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Price",
     *             "example"="/api/prices/1"
     *         }
     *     }
     * )
     */
    protected $orderTotal;

    /**
     * @var Price
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="App\Entity\Price", cascade={"persist"},
     *                                                orphanRemoval=true)
     * @JoinColumn(name="flower_total", referencedColumnName="id")
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Price",
     *             "example"="/api/prices/1"
     *         }
     *     }
     * )
     */
    protected $flowerTotal;

    /**
     * @var Price
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="App\Entity\Price", cascade={"persist"},
     *                                                orphanRemoval=true)
     * @JoinColumn(name="net_amount_total", referencedColumnName="id")
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Price",
     *             "example"="/api/prices/1"
     *         }
     *     }
     * )
     */
    protected $netAmountTotal;

    /**
     * @var Price
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="App\Entity\Price", cascade={"persist"},
     *                                                orphanRemoval=true)
     * @JoinColumn(name="service_cost", referencedColumnName="id")
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Price",
     *             "example"="/api/prices/1"
     *         }
     *     }
     * )
     */
    protected $serviceCost;

    /**
     * @var Price
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="App\Entity\Price", cascade={"persist"},
     *                                                orphanRemoval=true)
     * @JoinColumn(name="executing_member_cost", referencedColumnName="id")
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Price",
     *             "example"="/api/prices/1"
     *         }
     *     }
     * )
     */
    protected $executingMemberCost;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $executingMember;

    /**
     * @var Recipient
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="App\Entity\Recipient", cascade={"persist"},
     *                                                    orphanRemoval=true)
     * @JoinColumn(name="recipient", referencedColumnName="id")
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Recipient",
     *             "example"="/api/recipients/1"
     *         }
     *     }
     * )
     */
    protected $recipient;

    /**
     * @var Customer
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="App\Entity\Customer", cascade={"persist"},
     *                                                   orphanRemoval=true)
     * @JoinColumn(name="customer", referencedColumnName="id")
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Customer",
     *             "example"="/api/customers/1"
     *         }
     *     }
     * )
     */
    protected $customer;

    /**
     * @var Article[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="order",
     *                                                   cascade={"persist"},
     *                                                   orphanRemoval=true)
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Article[]",
     *             "example"="/api/articles/1"
     *         }
     *     }
     * )
     */
    protected $articles;

    /**
     * @var Payment[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Payment", mappedBy="order",
     *                                                   cascade={"persist"},
     *                                                   orphanRemoval=true)
     *
     * @Groups({"order_get", "order_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Payment[]",
     *             "example"="/api/payments/1"
     *         }
     *     }
     * )
     */
    protected $payments;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"order_get", "order_set"})
     */
    protected $print;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     *
     * @Groups({"order_get"})
     */
    protected $createdAt;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->externalReferences =  new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): ? string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Order
     */
    public function setId(string $id): Order
    {
        $this->id = $id;

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
     * @return Order
     */
    public function setOrderId(string $id): Order
    {
      $this->orderId = $id;

      return $this;
    }

    /**
     * @return string
     */
    public function getOrderType(): ? string
    {
        return $this->orderType;
    }

    /**
     * @param string $orderType
     *
     * @return Order
     */
    public function setOrderType(string $orderType): Order
    {

        if (!\in_array($orderType, self::ORDER_TYPES, true)) {
            throw new \InvalidArgumentException("Invalid order type");
        }

        $this->orderType = $orderType;

        return $this;
    }

    /**
     * @return Order
     */
    public function setOrderTypeInternational(): Order
    {
        return $this->setOrderType(self::ORDER_TYPE_INTERNATIONAL);
    }

    /**
     * @return Order
     */
    public function setOrderTypeNational(): Order
    {
        return $this->setOrderType(self::ORDER_TYPE_NATIONAL);
    }

    /**
     * @return bool
     */
    public function isInternationalOrder(): bool
    {
        return $this->getOrderType() === self::ORDER_TYPE_INTERNATIONAL;
    }

    /**
     * @return bool
     */
    public function isNationalOrder(): bool
    {
        return $this->getOrderType() === self::ORDER_TYPE_NATIONAL;
    }

    /**
     * @return string
     */
    public function getStatus(): ? string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Order
     */
    public function setStatus(string $status): Order
    {
        if ($this->isValidNationalStatus($status) || $this->isValidInternationalStatus($status)) {
            $this->status = $status;

            return $this;
        }

        throw new \InvalidArgumentException('Invalid status');
    }

    /**
     * @param $status
     *
     * @return bool
     */
    public function isValidNationalStatus($status): bool
    {
        return $this->isNationalOrder() && \in_array($status, self::NATIONAL_ORDER_STATUSES, true);
    }

    /**
     * @param $status
     *
     * @return bool
     */
    public function isValidInternationalStatus($status): bool
    {
        return $this->isInternationalOrder() && \in_array($status, self::INTERNATIONAL_ORDER_STATUSES, true);
    }

    /**
     * @return Order
     */
    public function setCanceled(): Order
    {
        return $this->setStatus(self::ORDER_STATUS_CANCELED);
    }

    /**
     * @return bool
     */
    public function isCanceled(): bool
    {
        return $this->getStatus() === self::ORDER_STATUS_CANCELED;
    }

    /**
     * @return string
     */
    public function getFromCountry(): ? string
    {
        return $this->fromCountry;
    }

    /**
     * @param string $fromCountry
     *
     * @return Order
     */
    public function setFromCountry(string $fromCountry): Order
    {
        $this->fromCountry = $fromCountry;

        return $this;
    }

    /**
     * @return string
     */
    public function getToCountry(): ? string
    {
        return $this->toCountry;
    }

    /**
     * @param string $toCountry
     *
     * @return Order
     */
    public function setToCountry(string $toCountry): Order
    {
        $this->toCountry = $toCountry;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeliveryDate(): ? \DateTime
    {
        return $this->deliveryDate;
    }

    /**
     * @param \DateTime $deliveryDate
     *
     * @return Order
     */
    public function setDeliveryDate($deliveryDate): Order
    {
        if (!$deliveryDate instanceof \DateTime) {
            $deliveryDate = new \DateTime($deliveryDate);
        }
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * @return ExternalReference[]
     */
    public function getExternalReferences()
    {
        return $this->externalReferences;
    }

    /**
     * @param ExternalReference[] $externalReferences
     *
     * @return Order
     */
    public function setExternalReferences(array $externalReferences): Order
    {
        $this->externalReferences = $externalReferences;

        foreach ($this->getExternalReferences() as $externalReference) {
            $externalReference->setOrder($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSendingMember(): ? string
    {
        return $this->sendingMember;
    }

    /**
     * @param string $sendingMember
     *
     * @return Order
     */
    public function setSendingMember(string $sendingMember): Order
    {
        $this->sendingMember = $sendingMember;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderRemarks(): ? string
    {
        return $this->orderRemarks;
    }

    /**
     * @param string $orderRemarks
     *
     * @return Order
     */
    public function setOrderRemarks(string $orderRemarks): Order
    {
        $this->orderRemarks = $orderRemarks;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate(): ? \DateTime
    {
        return $this->orderDate;
    }

    /**
     * @param \DateTime $orderDate
     *
     * @return Order
     */
    public function setOrderDate($orderDate): Order
    {
        if (!$orderDate instanceof \DateTime) {
            $orderDate = new \DateTime($orderDate);
        }

        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLeaveAtDoor(): bool
    {
        return $this->leaveAtDoor;
    }

    /**
     * @param bool $leaveAtDoor
     *
     * @return Order
     */
    public function setLeaveAtDoor(bool $leaveAtDoor): Order
    {
        $this->leaveAtDoor = $leaveAtDoor;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLeaveAtNeighbour(): bool
    {
        return $this->leaveAtNeighbour;
    }

    /**
     * @param bool $leaveAtNeighbour
     *
     * @return Order
     */
    public function setLeaveAtNeighbour(bool $leaveAtNeighbour): Order
    {
        $this->leaveAtNeighbour = $leaveAtNeighbour;

        return $this;
    }

    /**
     * @return bool
     */
    public function isConfirmSMS(): bool
    {
        return $this->confirmSMS;
    }

    /**
     * @param bool $confirmSMS
     *
     * @return Order
     */
    public function setConfirmSMS(bool $confirmSMS): Order
    {
        $this->confirmSMS = $confirmSMS;

        return $this;
    }

    /**
     * @return bool
     */
    public function isConfirmMail(): bool
    {
        return $this->confirmMail;
    }

    /**
     * @param bool $confirmMail
     *
     * @return Order
     */
    public function setConfirmMail(bool $confirmMail): Order
    {
        $this->confirmMail = $confirmMail;

        return $this;
    }

    /**
     * @return Price
     */
    public function getOrderTotal(): ? Price
    {
        return $this->orderTotal;
    }

    /**
     * @param Price $orderTotal
     *
     * @return Order
     */
    public function setOrderTotal(Price $orderTotal): Order
    {
        $this->orderTotal = $orderTotal;

        return $this;
    }

    /**
     * @return Price
     */
    public function getFlowerTotal(): ? Price
    {
        return $this->flowerTotal;
    }

    /**
     * @param Price $flowerTotal
     *
     * @return Order
     */
    public function setFlowerTotal(Price $flowerTotal): Order
    {
        $this->flowerTotal = $flowerTotal;

        return $this;
    }

    /**
     * @return Price
     */
    public function getNetAmountTotal(): ? Price
    {
        return $this->netAmountTotal;
    }

    /**
     * @param Price $netAmountTotal
     *
     * @return Order
     */
    public function setNetAmountTotal(Price $netAmountTotal): Order
    {
        $this->netAmountTotal = $netAmountTotal;

        return $this;
    }

    /**
     * @return Price
     */
    public function getServiceCost(): ? Price
    {
        return $this->serviceCost;
    }

    /**
     * @param Price $serviceCost
     *
     * @return Order
     */
    public function setServiceCost(Price $serviceCost): Order
    {
        $this->serviceCost = $serviceCost;

        return $this;
    }

    /**
     * @return Price
     */
    public function getExecutingMemberCost(): ? Price
    {
        return $this->executingMemberCost;
    }

    /**
     * @param Price $executingMemberCost
     *
     * @return Order
     */
    public function setExecutingMemberCost(Price $executingMemberCost): Order
    {
        $this->executingMemberCost = $executingMemberCost;

        return $this;
    }

    /**
     * @return string
     */
    public function getExecutingMember(): ? string
    {
        return $this->executingMember;
    }

    /**
     * @param string $executingMember
     *
     * @return Order
     */
    public function setExecutingMember(string $executingMember): Order
    {
        $this->executingMember = $executingMember;

        return $this;
    }

    /**
     * @return Recipient
     */
    public function getRecipient(): ? Recipient
    {
        return $this->recipient;
    }

    /**
     * @param Recipient $recipient
     *
     * @return Order
     */
    public function setRecipient(Recipient $recipient): Order
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): ? Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     *
     * @return Order
     */
    public function setCustomer(Customer $customer): Order
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Article[]
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article[] $articles
     *
     * @return Order
     */
    public function setArticles($articles): Order
    {
        $this->articles = $articles;

        foreach ($this->getArticles() as $article) {
            $article->setOrder($this);
        }

        return $this;
    }

    /**
     * @return Payment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param Payment[] $payments
     *
     * @return Order
     */
    public function setPayments(array $payments): Order
    {
        $this->payments = $payments;

        foreach ($this->getPayments() as $payment) {
            $payment->setOrder($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPrint(): ? string
    {
        return $this->print;
    }

    /**
     * @param string $print
     *
     * @return Order
     */
    public function setPrint(string $print): Order
    {
        $this->print = $print;

        return $this;
    }



}
