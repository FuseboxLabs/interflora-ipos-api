<?php


namespace Interflora\IposApi\Entity;
/**
 * Class ExternalReference
 */
class ExternalReference
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var string
     */
    protected $service;


    /**
     * @var string External order id
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
