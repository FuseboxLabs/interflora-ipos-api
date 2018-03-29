<?php

namespace Interflora\Ipos;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Debitor
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ApiResource(
 *   attributes={
 *     "normalization_context"={
 *       "groups"={"debitor_get"}
 *     },
 *    "denormalization_context"={
 *       "groups"={"debitor_set"}
 *     }
 *   }
 * )
 */
class Debitor
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"debitor_get"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=4, nullable=false)
     *
     * @Groups({"debitor_get", "debitor_set", "get", "set"})
     */
    protected $type = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Groups({"debitor_get", "debitor_set", "get", "set"})
     */
    protected $ean = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"recipient_get", "recipient_set", "get", "set"})
     */
    protected $cvr = '';

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"recipient_get", "recipient_set", "get", "set"})
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
