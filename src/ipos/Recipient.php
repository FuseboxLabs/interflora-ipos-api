<?php

namespace Interflora\ipos\Entity;
/**
 * Class Recipient
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ApiResource(
 *   attributes={
 *     "normalization_context"={
 *       "groups"={"recipient_get"}
 *     },
 *    "denormalization_context"={
 *       "groups"={"recipient_set"}
 *     }
 *   }
 * )
 */
class Recipient
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"recipient_get"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"recipient_get", "recipient_set"})
     */
    protected $name;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"recipient_get", "recipient_set"})
     */
    protected $co;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"recipient_get", "recipient_set"})
     */
    protected $name2;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"recipient_get", "recipient_set"})
     */
    protected $street;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"recipient_get", "recipient_set"})
     */
    protected $zip;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"recipient_get", "recipient_set"})
     */
    protected $city;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"recipient_get", "recipient_set"})
     */
    protected $phone;

    /**
     * @TODO create GEO entity, or leave it as a string?
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"recipient_get", "recipient_set"})
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
    public function getName2(): string
    {
        return $this->name2;
    }

    /**
     * @param string $name2
     *
     * @return Recipient
     */
    public function setName2(string $name2): Recipient
    {
        $this->name2 = $name2;

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
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return Recipient
     */
    public function setPhone(string $phone): Recipient
    {
        $this->phone = $phone;

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
