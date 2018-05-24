<?php

namespace Interflora\IposApi\Entity;
/**
 * Class Recipient
 */
class Recipient
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $co;

    /**
     * @var string
     */
    protected $street;

    /**
     * @var string
     */
    protected $street2;

  /**
     * @var string
     */
    protected $zip;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $church = '';

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $deliveryLocation;

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
     * @return Recipient
     */
    public function setId(int $id): Recipient
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Recipient
     */
    public function setName(string $name): Recipient
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCo(): string
    {
        return $this->co;
    }

    /**
     * @param string $co
     *
     * @return Recipient
     */
    public function setCo(string $co): Recipient
    {
        $this->co = $co;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet2(): string
    {
        return $this->street2;
    }

    /**
     * @param string $street2
     *
     * @return Recipient
     */
    public function setStreet2(string $street2): Recipient
    {
        $this->street2 = $street2;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     *
     * @return Recipient
     */
    public function setStreet(string $street): Recipient
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     *
     * @return Recipient
     */
    public function setZip(string $zip): Recipient
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Recipient
     */
    public function setCity(string $city): Recipient
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getChurch(): string
    {
        return $this->church;
    }

    /**
     * @param string $church
     *
     * @return Recipient
     */
    public function setChurch(string $church): Recipient
    {
        $this->church = $church;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phone
     *
     * @return Recipient
     */
    public function setPhone(string $phone): Recipient
    {
        $this->phoneNumber = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeliveryLocation(): string
    {
        return $this->deliveryLocation;
    }

    /**
     * @param string $deliveryLocation
     *
     * @return Recipient
     */
    public function setDeliveryLocation(string $deliveryLocation): Recipient
    {
        $this->deliveryLocation = $deliveryLocation;

        return $this;
    }

}
