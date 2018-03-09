<?php

namespace Interflora\Ipos;

/**
 * Class Article
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ApiResource(
 *   attributes={
 *     "normalization_context"={
 *       "groups"={"article_get"}
 *     },
 *    "denormalization_context"={
 *       "groups"={"article_set"}
 *     }
 *   }
 * )
 */
class Article
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"article_get"})
     */
    protected $id;

    /**
     * @var Order
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="articles")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *
     * @Groups({"article_get", "article_set"})
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
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"article_get", "article_set"})
     */
    protected $artCode;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="text")
     *
     * @Groups({"article_get", "article_set", "get", "set"})
     */
    protected $type;

    /**
     * @var int
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="integer")
     *
     * @Groups({"article_get", "article_set"})
     */
    protected $quantity;

    /**
     * @var Price
     *
     * @Gedmo\Versioned
     * @ORM\OneToOne(targetEntity="App\Entity\Price", cascade={"persist"}, orphanRemoval=true)
     * @JoinColumn(name="price", referencedColumnName="id")
     *
     * @Groups({"article_get", "article_set"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="Price",
     *             "example"="/api/prices/1"
     *         }
     *     }
     * )
     */
    protected $price;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="text")
     *
     * @Groups({"article_get", "article_set"})
     */
    protected $description;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="text")
     *
     * @Groups({"article_get", "article_set"})
     */
    protected $comment;

    /**
     * @var int
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="integer")
     *
     * @Groups({"article_get", "article_set"})
     */
    protected $productGroup;

    /**
     * @var bool
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="boolean")
     *
     * @Groups({"article_get", "article_set"})
     */
    protected $netAmountArticle;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"article_get", "article_set"})
     */
    protected $picturePath;

    /**
     * @var int
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="integer")
     *
     * @Groups({"article_get", "article_set"})
     */
    protected $vatRate;

    /**
     * @var Article[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="article",
     *                                                   cascade={"persist"},
     *                                                   orphanRemoval=true)
     *
     * @Groups({"article_get", "article_set", "get", "set"})
     */
    protected $subArticles = [];

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(type="json")
     *
     * @Groups({"payment_get", "payment_set"})
     */
    protected $data;

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
     * @return Article
     */
    public function setId(int $id): Article
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
     * @return Article
     */
    public function setOrder(Order $order): Article
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return string
     */
    public function getArtCode(): string
    {
        return $this->artCode;
    }

    /**
     * @param string $artCode
     *
     * @return Article
     */
    public function setArtCode(string $artCode): Article
    {
        $this->artCode = $artCode;

        return $this;
    }

    /**
     * Get the article type, e.g. product, bundle, etc.
     *
     * @return string
     *   The string representation of the article type.
     */
    public function getType(): string
    {
      return $this->type;
    }

    /**
     * Set the article type.
     *
     * @param string $type The string representation of the article type.
     *
     * @return Article
     */
    public function setType(string $type): Article
    {
      $this->type = $type;

      return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return Article
     */
    public function setQuantity(int $quantity): Article
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @param Price $price
     *
     * @return Article
     */
    public function setPrice(Price $price): Article
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Article
     */
    public function setDescription(string $description): Article
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return Article
     */
    public function setComment(string $comment): Article
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return int
     */
    public function getProductGroup(): int
    {
        return $this->productGroup;
    }

    /**
     * @param int $productGroup
     *
     * @return Article
     */
    public function setProductGroup(int $productGroup): Article
    {
        $this->productGroup = $productGroup;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNetAmountArticle(): bool
    {
        return $this->netAmountArticle;
    }

    /**
     * @param bool $netAmountArticle
     *
     * @return Article
     */
    public function setNetAmountArticle(bool $netAmountArticle): Article
    {
        $this->netAmountArticle = $netAmountArticle;

        return $this;
    }

    /**
     * @return string
     */
    public function getPicturePath(): string
    {
        return $this->picturePath;
    }

    /**
     * @param string $picturePath
     *
     * @return Article
     */
    public function setPicturePath(string $picturePath): Article
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    /**
     * @return int
     */
    public function getVatRate(): int
    {
        return $this->vatRate;
    }

    /**
     * @param int $vatRate
     *
     * @return Article
     */
    public function setVatRate(int $vatRate): Article
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    /**
     * Get a list of sub articles.
     * This is relevant for bundle products,
     * which are comprised of multiple other products.
     *
     * @return Article[]
     */
    public function getSubArticles()
    {
      return $this->subArticles;
    }

    /**
     * Set the sub articles.
     *
     * @param Article[] $articles A collections of articles.
     *
     * @return Article
     */
    public function setSubArticles($articles): Article
    {
      $this->subArticles = $articles;

      return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
      return $this->data;
    }

    /**
     * @param string $data
     *
     * @return Article
     */
    public function setData(string $data): Article
    {
      $this->data = $data;

      return $this;
    }

}
