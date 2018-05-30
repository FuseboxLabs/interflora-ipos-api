<?php

namespace Interflora\IposApi\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Debitor
 */
class Debitor
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
    protected $type = '';

    /**
     * @var string
     */
    protected $ean = '';

    /**
     * @var string
     */
    protected $cvr = '';

    /**
     * @var string
     */
    protected $debitorNumber = '';

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
     * @return debitor
     */
    public function setId(int $id): debitor
    {
        $this->id = $id;

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
     * @return Debitor
     */
    public function setType(string $type): Debitor
    {
      $this->type = $type;

      return $this;
    }

    /**
     * @return string
     */
    public function getEan(): string
    {
        return $this->ean;
    }

    /**
     * @param string $ean
     *
     * @return Debitor
     */
    public function setEan(string $ean): Debitor
    {
        $this->ean = $ean;

        return $this;
    }

    /**
     * @return string
     */
    public function getCvr(): string
    {
        return $this->cvr;
    }

    /**
     * @param string $cvr
     *
     * @return Debitor
     */
    public function setCvr(string $cvr): Debitor
    {
        $this->cvr = $cvr;

        return $this;
    }

    /**
     * @return string
     */
    public function getDebitorNumber(): string
    {
        return $this->debitorNumber;
    }

    /**
     * @param string $debitorNumber
     *
     * @return Debitor
     */
    public function setDebitorNumber(string $debitorNumber): Debitor
    {
        $this->debitorNumber = $debitorNumber;

        return $this;
    }

}
