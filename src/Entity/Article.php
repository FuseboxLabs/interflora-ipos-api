<?php

namespace Interflora\IposApi\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Article
 */
class Article
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var string
     */
    protected $artCode;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var float
     */
    protected $lineTotal;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $comment = '';

    /**
     * @var string
     */
    protected $productGroup;

    /**
     * @var bool
     */
    protected $netAmountArticle = false;

    /**
     * @var string
     */
    protected $picturePath = '';

    /**
     * @var array Array of strings.
     */
    protected $ribbons;

    /**
     * @var int
     */
    protected $vatRate;

    /**
     * @var array An array of articles.
     */
    protected $subArticles = [];

    /**
     * @var Article
     */
    protected $parent;

    /**
     * @var string
     */
    protected $data = '';

    /**
     * Article constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Article
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Sub articles doesn't have order due to doctrine limitations
     * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/working-with-associations.html#orphan-removal
     *
     * @return Order
     */
    public function getOrder():? Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     *
     * @return Article
     */
    public function setOrder(Order $order): self
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
    public function setArtCode(string $artCode): self
    {
        $this->artCode = $artCode;

        return $this;
    }

    /**
     * Get the article type, e.g. product, bundle, etc.
     *
     * @return string
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
    public function setType(string $type): self
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
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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
     * @return Article
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getLineTotal(): float
    {
        return $this->lineTotal;
    }

    /**
     * @param float $total
     *
     * @return Article
     */
    public function setLineTotal(float $total): self
    {
        $this->lineTotal = $total;

        return $this;
    }

    /**
     * @return Article|null
     */
    public function getParent(): ?Article
    {
        return $this->parent;
    }

    /**
     * @param Article $parent
     *
     * @return Article
     */
    public function setParent(Article $parent): self
    {
        $this->parent = $parent;

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
    public function setDescription(string $description): self
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
    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getProductGroup(): string
    {
        return $this->productGroup;
    }

    /**
     * @param string $productGroup
     *
     * @return Article
     */
    public function setProductGroup(string $productGroup): self
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
    public function setNetAmountArticle(bool $netAmountArticle): self
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
    public function setPicturePath(string $picturePath): self
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    /**
     * @return array
     */
    public function getRibbons()
    {
        return $this->ribbons;
    }

    /**
     * @param array $ribbons
     *
     * @return Article
     */
    public function setRibbons($ribbons): self
    {
        $this->ribbons = $ribbons;

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
    public function setVatRate(int $vatRate): self
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    /**
     * Get a list of sub articles.
     * This is relevant for bundle products,
     * which are comprised of multiple other products.
     *
     * @return array
     */
    public function getSubArticles(): array
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
    public function setSubArticles($articles): self
    {
        $this->subArticles = $articles;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSubArticles(): bool
    {
        return count($this->getSubArticles()) > 0;
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
    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

}
