<?php

namespace Interflora\IposApi\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Interflora\IposApi\Constant\CreditNoteStatus;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreditNote
 */
class CreditNote
{

    /**
     * National orders statuses
     */
    public const CREDIT_NOTE_STATUS = [
        CreditNoteStatus::NEW,
        CreditNoteStatus::COMPLETED,
        CreditNoteStatus::SYNC_ERROR,
    ];

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
    protected $status = CreditNoteStatus::NEW;

    /**
     * @var \DateTime
     *
     * @Assert\DateTime()
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $createdBy;

    /**
     * @var string
     */
    protected $updatedBy;

    /**
     * @var float
     *
     * @Assert\NotNull()
     */
    protected $price;

    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $note;

    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $debtor;

    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $account = '';

    /**
     * @var boolean
     */
    protected $appliedToProduct = false;

    /**
     * @var Article
     */
    protected $product;

    /**
     * @var boolean
     */
    protected $appliedToDelivery = false;

    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $pdfUrl = '';

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
     * @return CreditNote
     */
    public function setId(int $id): self
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
     * @return CreditNote
     */
    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return CreditNote
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getDebtor()
    {
        return $this->debtor;
    }

    /**
     * @param string $debtor
     *
     * @return CreditNote
     */
    public function setDebtor(string $debtor): self
    {
        $this->debtor = $debtor;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param string $account
     *
     * @return CreditNote
     */
    public function setAccount(string $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return string
     */
    public function getPdfUrl()
    {
        return $this->pdfUrl;
    }

    /**
     * @param string $pdfUrl
     *
     * @return CreditNote
     */
    public function setPdfUrl(string $pdfUrl): self
    {
        $this->pdfUrl = $pdfUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * @param string $note
     *
     * @return CreditNote
     */
    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return CreditNote
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAppliedToProduct(): bool
    {
        return $this->appliedToProduct;
    }

    /**
     * @param bool $appliedToProduct
     */
    public function setAppliedToProduct(bool $appliedToProduct): void
    {
        $this->appliedToProduct = $appliedToProduct;
    }

    /**
     * @return Article|null
     */
    public function getProduct(): ?Article
    {
        return $this->product;
    }

    /**
     * @param Article $product
     */
    public function setProduct(Article $product): void
    {
        $this->product = $product;
    }

    /**
     * @return bool
     */
    public function isAppliedToDelivery(): bool
    {
        return $this->appliedToDelivery;
    }

    /**
     * @param bool $appliedToDelivery
     */
    public function setAppliedToDelivery(bool $appliedToDelivery): void
    {
        $this->appliedToDelivery = $appliedToDelivery;
    }

}
