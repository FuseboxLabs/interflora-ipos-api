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
     * National orders statuses
     */
    public const NATIONAL_ORDER_STATUSES = [
        OrderStatus::NEW,
        OrderStatus::NOT_PRINTED,
        OrderStatus::PRINTED,
        OrderStatus::DELIVERED,
        OrderStatus::CANCELED,
        OrderStatus::COMPLETED,
    ];

    /**
     * International order statuses
     */
    public const INTERNATIONAL_ORDER_STATUSES = [
        OrderStatus::NEW,
        OrderStatus::PENDING_APPROVAL,
        OrderStatus::OUTGOING,
        OrderStatus::SENT,
        OrderStatus::COMPLETED,
    ];

    /**
     * Statuses of order that is considered as not delivered
     */
    public const ORDER_STATUSES_NOT_DELIVERED = [
        OrderStatus::NEW,
        OrderStatus::NOT_PRINTED,
        OrderStatus::PRINTED,
    ];


    /**
     * Statuses of order that is considered as delivered
     */
    public const ORDER_STATUSES_DELIVERED = [
        OrderStatus::DELIVERED,
        OrderStatus::COMPLETED,
    ];

    /**
     * All order statuses
     */
    public const ORDER_STATUSES = self::INTERNATIONAL_ORDER_STATUSES + self::NATIONAL_ORDER_STATUSES;

    /**
     * Order types
     */
    public const ORDER_TYPES = [
        OrderType::NATIONAL,
        OrderType::INTERNATIONAL,
    ];

    /**
     * Order prefix map to source
     */
    public const ORDER_PREFIX_MAP = [
        55 => 'interflora.dk',
        11 => 'posy',
    ];

    /**
     * Pattern to take prefix from order number, i.e. prefix 55 will be taken from 55-131-2131-321
     */
    public const ORDER_NUMBER_PREFIX_PATTERN = '/^(.+?)-/';

    /**
     * Order categories
     */
    public const ORDER_CATEGORIES = [
        OrderCategory::STANDARD,
        OrderCategory::FUNERAL,
        OrderCategory::GIFT_CARD,
    ];

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     * @Groups({"get"})
     */
    protected $id;

    /**
     * Order id from external systems.
     *
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"get", "set"})
     */
    protected $orderId;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"get"})
     */
    protected $sourceInformation;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=20)
     *
     * @Groups({"get", "set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "enum"={Order::ORDER_TYPES},
     *             "example"=Order::ORDER_TYPE_NATIONAL
     *         }
     *     }
     * )
     */
    protected $orderType = OrderType::NATIONAL;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=20)
     *
     * @Groups({"get", "set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "enum"={Order::ORDER_CATEGORIES},
     *             "example"=Order::STANDARD
     *         }
     *     }
     * )
     */
    protected $category = OrderCategory::STANDARD;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=20)
     *
     * @Groups({"get", "set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "enum"={Order::ORDER_STATUSES},
     *             "example"=Order::NEW
     *         }
     *     }
     * )
     */
    protected $status = OrderStatus::NEW;

    /**
     * @var bool
     *
     * @Groups({"get"})
     */
    protected $isDelivered;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"get", "set"})
     */
    protected $fromCountry;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"get", "set"})
     */
    protected $toCountry;

    /**
     * @var \DateTime
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="datetime")
     *
     * @Groups({"get", "set"})
     */
    protected $deliveryDate;

    /**
     * @var \DateTime
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="datetime")
     *
     * @Groups({"get", "set"})
     */
    protected $funeralTime;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=100)
     *
     * @Groups({"get", "set"})
     */
    protected $deliveryInterval = '';

    /**
     * @var ExternalReference[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\ExternalReference", mappedBy="order", cascade={"persist"},
     *                                                             orphanRemoval=true)
     *
     * @Groups({"get", "set"})
     */
    protected $externalReferences;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"get", "set"})
     */
    protected $sendingMember;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"get", "set"})
     */
    protected $orderRemarks = '';

    /**
     * @var \DateTime
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="datetime")
     *
     * @Groups({"get", "set"})
     */
    protected $orderDate;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"get", "set"})
     */
    protected $leaveAtDoor = false;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"get", "set"})
     */
    protected $leaveAtNeighbour = false;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"get", "set"})
     */
    protected $confirmSMS = false;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"get", "set"})
     */
    protected $confirmMail = false;

    /**
     * @var float
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="float", precision=2)
     *
     * @Groups({"get", "set"})
     */
    protected $orderTotal;

    /**
     * @var float
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="float", precision=2)
     *
     * @Groups({"get", "set"})
     */
    protected $flowerTotal;

    /**
     * @var float
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="float", precision=2)
     *
     * @Groups({"get", "set"})
     */
    protected $netAmountTotal;

    /**
     * @var float
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="float", precision=2)
     *
     * @Groups({"get", "set"})
     */
    protected $serviceCost;

    /**
     * @var float
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="float", precision=2)
     *
     * @Groups({"get", "set"})
     */
    protected $executingMemberCost;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Groups({"get", "set"})
     */
    protected $currency;

    /**
     * @var integer
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups({"get", "set"})
     */
    protected $executingMember;

    /**
     * @var Recipient
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\Recipient",
     *     cascade={"persist"},
     *     orphanRemoval=true
     * )
     * @JoinColumn(
     *     name="recipient",
     *     referencedColumnName="id"
     * )
     *
     * @Groups({"get", "set"})
     */
    protected $recipient;

    /**
     * @var Customer
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\Customer",
     *     cascade={"persist"},
     *     orphanRemoval=true
     * )
     * @JoinColumn(
     *     name="customer",
     *     referencedColumnName="id"
     * )
     *
     * @Groups({"get", "set"})
     */
    protected $customer;

    /**
     * @var Article[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Article",
     *     mappedBy="order",
     *     cascade={"persist"},
     *     orphanRemoval=true
     * )
     *
     * @Groups({"get", "set"})
     */
    protected $articles;

    /**
     * @var Payment[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Payment",
     *     mappedBy="order",
     *     cascade={"persist"},
     *     orphanRemoval=true
     * )
     *
     * @Groups({"get", "set"})
     */
    protected $payments;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"get", "set"})
     */
    protected $print = '';

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     *
     * @Groups({"get"})
     */
    protected $createdAt;

    /**
     * @var Note[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Note",
     *     mappedBy="order",
     *     cascade={"persist"},
     *     orphanRemoval=true
     * )
     * @Groups({"get"})
     * @ApiSubresource
     */
    protected $notes;

    /**
     * @var string[]|ArrayCollection

     * @Groups({"get", "set"})
     */
    protected $ribbons;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=20)
     *
     * @Groups({"get", "set"})
     */
    protected $ipAddress = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="json")
     *
     * @Groups({"article_get", "article_set"})
     */
    protected $data = '';

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->externalReferences = [];
        $this->payments = [];
        $this->articles = [];
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
    public function setOrderId(string $orderId): Order
    {
        $this->orderId = $orderId;

        $this->setSourceInformation();

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceInformation(): string
    {
        return $this->sourceInformation;
    }

    /**
     * @return Order
     */
    protected function setSourceInformation(): Order
    {
        $this->sourceInformation = '';
        preg_match(self::ORDER_NUMBER_PREFIX_PATTERN, $this->getOrderId(), $sourceInformation);
        if (isset($sourceInformation[1])) {
            $prefix = $sourceInformation[1];
            if (array_key_exists($prefix, self::ORDER_PREFIX_MAP)) {
                $this->sourceInformation = self::ORDER_PREFIX_MAP[$prefix];
            }
        }
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
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid order type provided: %s. Available types: %s',
                    $orderType,
                    implode(', ', self::ORDER_TYPES)
                )
            );
        }

        $this->orderType = $orderType;

        return $this;
    }

    /**
     * @return Order
     */
    public function setOrderTypeInternational(): Order
    {
        return $this->setOrderType(OrderType::INTERNATIONAL);
    }

    /**
     * @return Order
     */
    public function setOrderTypeNational(): Order
    {
        return $this->setOrderType(OrderType::NATIONAL);
    }

    /**
     * @return bool
     */
    public function isInternationalOrder(): bool
    {
        return $this->getOrderType() === OrderType::INTERNATIONAL;
    }

    /**
     * @return bool
     */
    public function isNationalOrder(): bool
    {
        return $this->getOrderType() === OrderType::NATIONAL;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     *
     * @return Order
     */
    public function setCategory(string $category): Order
    {
        if (!\in_array($category, self::ORDER_CATEGORIES, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid order category provided: %s. Available categories: %s',
                    $category,
                    implode(', ', self::ORDER_CATEGORIES)
                )
            );
        }

        $this->category = $category;

        return $this;
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
        if ($this->isValidStatus($status)) {
            $this->status = $status;

            return $this;
        }

        $availableStatuses = $this->isNationalOrder() ? self::NATIONAL_ORDER_STATUSES : self::INTERNATIONAL_ORDER_STATUSES;

        throw new \InvalidArgumentException(
            sprintf(
                'Invalid order status provided: %s. Available statuses for order type %s: %s',
                $status,
                $this->getOrderType(),
                implode(', ', $availableStatuses)
            )
        );
    }

    /**
     * @param string $status
     *
     * @return bool
     */
    public function isValidStatus($status): bool
    {
        return $this->isValidNationalStatus($status) || $this->isValidInternationalStatus($status);
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
     * @return bool
     */
    public function isDelivered():? bool
    {
        return $this->isDelivered;
    }

    /**
     * @return Order
     */
    public function setCanceled(): Order
    {
        return $this->setStatus(OrderStatus::CANCELED);
    }

    /**
     * @return bool
     */
    public function isCanceled(): bool
    {
        return $this->getStatus() === OrderStatus::CANCELED;
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
    public function getDeliveryDate(): \DateTime
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
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFuneralTime(): \DateTime
    {
        return $this->funeralTime;
    }

    /**
     * @param \DateTime $funeralTime
     *
     * @return Order
     */
    public function setFuneralTime($funeralTime): Order
    {
        $this->funeralTime = $funeralTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeliveryInterval(): string
    {
        return $this->deliveryInterval;
    }

    /**
     * @param string $deliveryInterval
     *
     * @return Order
     */
    public function setDeliveryInterval(string $deliveryInterval): Order
    {
        $this->deliveryInterval = $deliveryInterval;

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
     * @return float
     */
    public function getOrderTotal(): float
    {
        return $this->orderTotal;
    }

    /**
     * @param float $orderTotal
     *
     * @return Order
     */
    public function setOrderTotal(float $orderTotal): Order
    {
        $this->orderTotal = $orderTotal;

        return $this;
    }

    /**
     * @return float
     */
    public function getFlowerTotal(): float
    {
        return $this->flowerTotal;
    }

    /**
     * @param float $flowerTotal
     *
     * @return Order
     */
    public function setFlowerTotal(float $flowerTotal): Order
    {
        $this->flowerTotal = $flowerTotal;

        return $this;
    }

    /**
     * @return float
     */
    public function getNetAmountTotal(): float
    {
        return $this->netAmountTotal;
    }

    /**
     * @param float $netAmountTotal
     *
     * @return Order
     */
    public function setNetAmountTotal(float $netAmountTotal): Order
    {
        $this->netAmountTotal = $netAmountTotal;

        return $this;
    }

    /**
     * @return float
     */
    public function getServiceCost(): float
    {
        return $this->serviceCost;
    }

    /**
     * @param float $serviceCost
     *
     * @return Order
     */
    public function setServiceCost(float $serviceCost): Order
    {
        $this->serviceCost = $serviceCost;

        return $this;
    }

    /**
     * @return float
     */
    public function getExecutingMemberCost(): float
    {
        return $this->executingMemberCost;
    }

    /**
     * @param float $executingMemberCost
     *
     * @return Order
     */
    public function setExecutingMemberCost(float $executingMemberCost): Order
    {
        $this->executingMemberCost = $executingMemberCost;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return Order
     */
    public function setCurrency(string $currency): Order
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return integer
     */
    public function getExecutingMember(): ? int
    {
        return $this->executingMember;
    }

    /**
     * @param integer $executingMember
     *
     * @return Order
     */
    public function setExecutingMember(int $executingMember = null): Order
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

    /**
     * @return Note[]|ArrayCollection
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param Note[]|ArrayCollection $notes
     *
     * @return Order
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return string[]|ArrayCollection
     */
    public function getRibbons()
    {
        return $this->notes;
    }

    /**
     * @param string[]|ArrayCollection $ribbons
     *
     * @return Order
     */
    public function setRibbons($ribbons)
    {
        $this->ribbons = $ribbons;

        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress(): ? string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     *
     * @return Order
     */
    public function setIpAddress(string $ipAddress): Order
    {
        $this->ipAddress = $ipAddress;

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
     * @return Order
     */
    public function setData(string $data): Order
    {
        $this->data = $data;

        return $this;
    }

}
