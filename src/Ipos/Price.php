<?php

namespace Interflora\Ipos;
/**
 * Class Price
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ApiResource(
 *   attributes={
 *     "normalization_context"={
 *       "groups"={"price_get"}
 *     },
 *    "denormalization_context"={
 *       "groups"={"price_set"}
 *     }
 *   }
 * )
 */
class Price
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     *
     * @Groups({"price_get"})
     */
    protected $id;

    /**
     * @var float
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="float", precision=2)
     *
     * @Groups({"price_get", "price_set"})
     */
    protected $number;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"price_get", "price_set"})
     */
    protected $currency;

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
     * @return Price
     */
    public function setId(int $id): Price
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return float
     */
    public function getNumber(): float
    {
        return $this->number;
    }

    /**
     * @param float $number
     *
     * @return Price
     */
    public function setNumber(float $number): Price
    {
        $this->number = $number;

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
     * @return Price
     */
    public function setCurrency(string $currency): Price
    {
        $this->currency = $currency;

        return $this;
    }


}