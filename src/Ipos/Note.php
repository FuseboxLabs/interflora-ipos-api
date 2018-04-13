<?php


namespace Interflora\Ipos;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Note
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ApiResource(
 *   attributes={
 *     "normalization_context"={
 *       "groups"={"note_get"}
 *     },
 *    "denormalization_context"={
 *       "groups"={"note_set"}
 *     },
 *    "filters"={
 *       "note.order_filter",
 *    }
 *   }
 * )
 */
class Note
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     *
     * @Groups({"note_get", "get"})
     */
    protected $id;

    /**
     * @var Order
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Order",
     *     inversedBy="notes"
     * )
     * @ORM\JoinColumn(
     *     name="order_id",
     *     referencedColumnName="id"
     * )
     *
     * @Groups({"note_get", "note_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Order",
     *             "example"="/api/orders/1"
     *         }
     *     }
     * )
     */
    protected $order;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"note_get", "note_set", "get"})
     */
    protected $visibleOnlyCS;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="text")
     *
     * @Groups({"note_get", "note_set", "get"})
     */
    protected $note;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     *
     * @Groups({"note_get", "get"})
     */
    protected $createdAt;

    /**
     * @var string
     * @Gedmo\Blameable(on="create")
     * @ORM\Column(nullable=true)
     *
     * @Groups({"note_get", "get"})
     */
    protected $createdBy;

    /**
     * @var string
     * @Gedmo\Blameable(on="update")
     * @ORM\Column(nullable=true)
     *
     * @Groups({"note_get", "get"})
     */
    protected $updatedBy;


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
