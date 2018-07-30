<?php

namespace Interflora\IposApi\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

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
     *
     * @Assert\NotNull()
     */
    protected $service;


    /**
     * @var string External order id
     *
     * @Assert\NotNull()
     */
    protected $orderId;

    /**
     * ExternalReference constructor.
     *
     * @param string $service
     *   The service key.
     * @param string $orderId
     *   The order id related to the key.
     */
    public function __construct(string $service = '', string $orderId = '')
    {
        $this
            ->setService($service)
            ->setOrderId($orderId);
    }


    /**
     * @return int
     */
    public function getId(): ? int
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
