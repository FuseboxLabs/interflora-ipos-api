<?php

namespace Interflora\IposApi\Entity;

/**
 * Class Customer
 */
class Customer
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $co = '';

    /**
     * @var string
     */
    protected $street = '';

    /**
     * @var string
     */
    protected $street2 = '';

    /**
     * @var string
     */
    protected $zip = '';

    /**
     * @var string
     */
    protected $city = '';

    /**
     * @var string
     */
    protected $phoneNumber = '';

    /**
     * @var string
     *
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    protected $mail;

    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $type = 'b2c';

    /**
     * @var Debitor
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
    public function getStreet2(): string
    {
        return $this->street2;
    }

    /**
     * @param string $street2
     *
     * @return Customer
     */
    public function setStreet2(string $street2): Customer
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
        return $this->phoneNumber;
    }

    /**
     * @param string $phone
     *
     * @return Customer
     */
    public function setPhone(string $phone): Customer
    {
        $this->phoneNumber = $phone;

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

    /**
     * @return Debitor
     */
    public function getDebitor(): Debitor
    {
      return $this->debitor;
    }

    /**
     * @param string $debitor
     *
     * @return Customer
     */
    public function setDebitor(Debitor $debitor): Customer
    {
      $this->debitor = $debitor;

      return $this;
    }

}
