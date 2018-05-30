<?php


namespace Interflora\IposApi\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Note
 */
class Note
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
     * @var bool
     *
     * @Assert\NotNull()
     */
    protected $visibleOnlyCS = false;

    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $note;

    /**
     * @var \DateTime
     *
     * @Assert\DateTime()
     */
    protected $createdAt;


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
     * @return Note
     */
    public function setId(int $id): Note
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
     * @return Note
     */
    public function setOrder(Order $order): Note
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVisibleOnlyCS(): bool
    {
        return $this->visibleOnlyCS;
    }

    /**
     * @param bool $visibleOnlyCS
     *
     * @return Note
     */
    public function setVisibleOnlyCS(bool $visibleOnlyCS): Note
    {
        $this->visibleOnlyCS = $visibleOnlyCS;

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
     * @return Note
     */
    public function setNote(string $note): Note
    {
        $this->note = $note;

        return $this;
    }

}
