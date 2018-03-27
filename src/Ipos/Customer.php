<?php

namespace Interflora\Ipos;

/**
 * Class Customer
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ApiResource(
 *   attributes={
 *     "normalization_context"={
 *       "groups"={"customer_get"}
 *     },
 *    "denormalization_context"={
 *       "groups"={"customer_set"}
 *     }
 *   }
 * )
 */
class Customer
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"customer_get"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"customer_get", "customer_set", "get", "set"})
     */
    protected $name = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"recipient_get", "recipient_set", "get", "set"})
     */
    protected $co = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"recipient_get", "recipient_set", "get", "set"})
     */
    protected $name2 = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"recipient_get", "recipient_set", "get", "set"})
     */
    protected $street = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"recipient_get", "recipient_set", "get", "set"})
     */
    protected $zip = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"recipient_get", "recipient_set", "get", "set"})
     */
    protected $city = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"customer_get", "customer_set", "get", "set"})
     */
    protected $phone = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"customer_get", "customer_set", "get", "set"})
     */
    protected $mail;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"customer_get", "customer_set", "get", "set"})
     */
    protected $type = 'b2c';

    /**
     * @var Debitor
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\Debitor",
     *     cascade={"persist"},
     *     orphanRemoval=true
     * )
     * @JoinColumn(
     *     name="debitor",
     *     referencedColumnName="id"
     * )
     *
     * @Groups({"get", "set"})
     */
    protected $debitor;

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
     * @return Customer
     */
    public function setId(int $id): Customer
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
     * @return Customer
     */
    public function setName(string $name): Customer
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
     * @return Customer
     */
    public function setCo(string $co): Customer
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
     * @return Customer
     */
    public function setName2(string $name2): Customer
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
     * @return Customer
     */
    public function setStreet(string $street): Customer
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
     * @return Customer
     */
    public function setZip(string $zip): Customer
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
     * @return Customer
     */
    public function setCity(string $city): Customer
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
     * @return Customer
     */
    public function setPhone(string $phone): Customer
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     *
     * @return Customer
     */
    public function setMail(string $mail): Customer
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Customer
     */
    public function setType(string $type): Customer
    {
        $this->type = $type;

        return $this;
    }

}
