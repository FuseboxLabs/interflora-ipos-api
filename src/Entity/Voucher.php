<?php

namespace Interflora\IposApi\Entity;


/**
 * Class Voucher
 */
class Voucher
{


    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $promotionCode;

    /**
     * @var string
     */
    protected $promotionName;


    /**
     * @var int
     */
    protected $discountAmount;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPromotionCode(): string
    {
        return $this->promotionCode;
    }

    /**
     * @param string $promotionCode
     *
     * @return $this
     */
    public function setPromotionCode(string $promotionCode): self
    {
        $this->promotionCode = $promotionCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPromotionName(): string
    {
        return $this->promotionName;
    }

    /**
     * @param string $promotionName
     *
     * @return $this
     */
    public function setPromotionName(string $promotionName): self
    {
        $this->promotionName = $promotionName;

        return $this;
    }

    /**
     * @return int
     */
    public function getDiscountAmount(): int
    {
        return $this->discountAmount;
    }

    /**
     * @param int $discountAmount
     *
     * @return $this
     */
    public function setDiscountAmount(int $discountAmount): self
    {
        $this->discountAmount = $discountAmount;

        return $this;
    }

}
