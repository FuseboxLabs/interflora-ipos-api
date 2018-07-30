<?php
namespace Interflora\IposApi\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Interflora\IposApi\Constant\OrderCategory;
use Interflora\IposApi\Constant\OrderDeliveryStatus;
use Interflora\IposApi\Constant\OrderStatus;
use Interflora\IposApi\Constant\OrderType;
use Symfony\Component\Validator\Constraints as Assert;
use Interflora\IposApi\Validator\Constraints as InterfloraAssert;

/**
 * Class Order
 *
 * @InterfloraAssert\OrderTotal()
 * @InterfloraAssert\OrderTypeCountries()
 * @InterfloraAssert\ExecutingMemberCost()
 * @InterfloraAssert\FuneralOrder()
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
        OrderStatus::PAID,
        OrderStatus::PAYMENT_FAILED,
        OrderStatus::SYNC_ERROR,
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
        OrderStatus::SYNC_ERROR,
    ];

    /**
     * Statuses of order that is considered as not delivered
     */
    public const ORDER_STATUSES_NOT_DELIVERED = [
        OrderStatus::NEW,
        OrderStatus::NOT_PRINTED,
        OrderStatus::PRINTED,
        OrderDeliveryStatus::NOT_DELIVERED
    ];

    /**
     * Statuses of order that is considered as delivered
     */
    public const ORDER_STATUSES_DELIVERED = [
        OrderStatus::DELIVERED,
        OrderStatus::COMPLETED,
        OrderDeliveryStatus::DELIVERED_AT_CHURCH,
        OrderDeliveryStatus::DELIVERED_AT_DOOR,
        OrderDeliveryStatus::DELIVERED_PERSONAL,
        OrderDeliveryStatus::TAKEN_BACK
    ];

    /**
     * All order statuses
     */
    public const ORDER_STATUSES = self::INTERNATIONAL_ORDER_STATUSES + self::NATIONAL_ORDER_STATUSES;

    /**
     * If an order is in one of the states below, disallow delivery transitions
     */
    public const DISALLOW_DELIVERY_STATUS_UPDATE_STATUSES = [
        OrderStatus::SYNC_ERROR,
        OrderStatus::CANCELED,
        OrderStatus::COMPLETED
    ];

    /**
     * Statuses and transitions which will trigger publishing to a queue with the status' or transitions name
     * Before adding any new statuses to this array, you need to define a queue service
     */
    public const PUBLISH_TO_QUEUE_STATUSES = [
        OrderStatus::NOT_PRINTED,
        OrderStatus::DELIVERED,
        OrderStatus::PAID,
        OrderStatus::COMPLETED,
        OrderStatus::PENDING_APPROVAL,
        OrderStatus::OUTGOING,
        OrderStatus::SENT,
        OrderStatus::CANCELED,
    ];

    public const PUBLISH_TO_QUEUE_TRANSITIONS = [
        'reprint_order',
        'reprint_card'
    ];

    public const PAYMENT_STATUSES = [
        OrderStatus::DELIVERED,
        OrderStatus::PRINTED,
    ];

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
        22 => 'ifos',
        99 => 'floristgate'
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
     */
    protected $id;

    /**
     * Order id from external systems.
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $orderId;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $sourceInformation;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $orderType = OrderType::NATIONAL;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $category = OrderCategory::STANDARD;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $status = OrderStatus::NEW;

    /**
     * @var bool
     */
    protected $isDelivered;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $fromCountry;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $toCountry;

    /**
     * @var \DateTime
     *
     * @Assert\DateTime()
     */
    protected $deliveryDate;

    /**
     * @var \DateTime
     *
     * @Assert\DateTime()
     */
    protected $funeralTime;

    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $deliveryInterval = '';

    /**
     * @var ExternalReference[]|ArrayCollection
     */
    protected $externalReferences;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $sendingMember;

    /**
     * @var string
     */
    protected $orderRemarks = '';

    /**
     * @var \DateTime
     *
     * @Assert\DateTime()
     */
    protected $orderDate;

    /**
     * @var bool
     */
    protected $leaveAtDoor = false;

    /**
     * @var bool
     */
    protected $leaveAtNeighbour = false;

    /**
     * @var bool
     */
    protected $confirmSMS = false;

    /**
     * @var bool
     */
    protected $confirmMail = false;

    /**
     * @var float
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $orderTotal;

    /**
     * @var float
     */
    protected $flowerTotal = 0;

    /**
     * @var float
     */
    protected $netAmountTotal = 0;

    /**
     * @var float
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $serviceCost;

    /**
     * @var float
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $executingMemberCost;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $currency;

    /**
     * @var integer|null
     */
    protected $executingMember;

    /**
     * @var Recipient
     *
     * @Assert\NotBlank()
     * @Assert\Collection()
     */
    protected $recipient;

    /**
     * @var Customer
     *
     * @Assert\Collection()
     */
    protected $customer;

    /**
     * @var Article[]|ArrayCollection
     *
     * @Assert\NotBlank()
     * @Assert\Collection()
     */
    protected $articles;

    /**
     * @var Payment[]|ArrayCollection
     *
     * @Assert\NotBlank()
     * @Assert\Collection()
     */
    protected $payments;

    /**
     * @var string
     */
    protected $print = '';

    /**
     * @var bool
     */
    protected $isReprint = false;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var Note[]|ArrayCollection
     */
    protected $notes;

    /**
     * @var string[]|ArrayCollection
     */
    protected $ribbons;

    /**
     * @var string
     */
    protected $ipAddress = '';

    /**
     * @var string
     */
    protected $standardCardText = '';

    /**
     * @var string
     */
    protected $data = '';


    /**
     * @var string
     */
    protected $unitId = '';

    /**
     * @var Voucher|null
     */
    protected $voucher;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        
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
    public function getFuneralTime()
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
    public function setExternalReferences($externalReferences): Order
    {
        $this->externalReferences = $externalReferences;

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
    public function setPayments($payments): Order
    {
        $this->payments = $payments;
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
        return $this->ribbons;
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
    public function getStandardCardText(): string
    {
        return $this->standardCardText;
    }

    /**
     * @param string $standardCardText
     *
     * @return $this
     */
    public function setStandardCardText(string $standardCardText): self
    {
        $this->standardCardText = $standardCardText;

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

    /**
     * @return string
     */
    public function getUnitId(): string
    {
        return $this->unitId;
    }

    /**
     * @param string $unitId
     */
    public function setUnitId(string $unitId): Order
    {
        $this->unitId = $unitId;

        return $this;
    }

    /**
     * @return bool
     */
    public function isReprint(): bool
    {
        return $this->isReprint;
    }

    /**
     * @param bool $isReprint
     *
     * @return $this
     */
    public function setIsReprint(bool $isReprint): self
    {
        $this->isReprint = $isReprint;

        return $this;
    }

    /**
     * @return Voucher
     */
    public function getVoucher(): ?Voucher
    {
        return $this->voucher;
    }

    /**
     * @param Voucher $voucher
     *
     * @return $this
     */
    public function setVoucher(Voucher $voucher = null): self
    {
        $this->voucher = $voucher;

        return $this;
    }

}
