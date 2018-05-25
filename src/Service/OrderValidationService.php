<?php

namespace Interflora\IposApi\Service;

use Interflora\IposApi\Entity\Article;
use Interflora\IposApi\Entity\Order;
use Interflora\IposApi\Constant\OrderType;
use Interflora\IposApi\Entity\Recipient;

/**
 * Class OrderValidationService
 */
class OrderValidationService
{

    public const BUNDLE_ARTICLES = [
        'bundle',
        'dynamic_bundle',
    ];

    /**
     * Validate the order type and the countries set on the order data.
     *
     * @param object $order
     *
     * @return bool
     */
    public function validateOrderType(Order $order): bool
    {
        $isValid = true;
        if ($order->getOrderType() === OrderType::NATIONAL) {
            $isValid = ($order->getFromCountry() === $order->getToCountry());
        } elseif ($order->getOrderType() === OrderType::INTERNATIONAL) {
            $isValid = ($order->getFromCountry() !== $order->getToCountry());
        }

        return $isValid;
    }

    /**
     * @param Order $order
     *
     * @return bool
     */
    public function validateExecutingMemberCost(Order $order): bool
    {
        $serviceCost         = $order->getServiceCost();
        $executingMemberCost = $order->getExecutingMemberCost();

        return ($serviceCost >= $executingMemberCost);
    }

    /**
     * @param Order $order
     *
     * @return bool
     */
    public function validateOrderTotal(Order $order): bool
    {
        $orderTotal      = $order->getOrderTotal();
        $articles        = $order->getArticles();
        $calculatedTotal = 0;
        foreach ($articles as $article) {
            $calculatedTotal += $this->getArticleTotal($article);
        }

        $calculatedTotal += $order->getServiceCost();
        return ($orderTotal === $calculatedTotal);
    }

    /**
     * @param Article $article
     *
     * @return float
     */
    public function getArticleTotal(Article $article): float
    {
        $total = $article->getLineTotal();
        if ($article->hasSubArticles()) {
            foreach ($article->getSubArticles() as $subArticle) {
                $total += $this->getArticleTotal($subArticle);
            }
        }

        return $total;
    }

    /**
     * @param Article $article
     *
     * @return bool
     */
    public function validateBundle(Article $article): bool
    {
        if (!in_array($article->getType(), self::BUNDLE_ARTICLES)) {
            return true;
        }
        if (!$article->hasSubArticles()) {
            return false;
        }
        $bundlePrice   = $article->getLineTotal();
        $subArticles   = $article->getSubArticles();
        $subArticleSum = array_sum(array_map(function ($subArticle) {
            return $subArticle->getLineTotal();
        }, $subArticles));
        return ($bundlePrice === $subArticleSum);
    }

    /**
     * @param Recipient $recipient
     *
     * @return bool
     */
    public function validateChurch(Recipient $recipient): bool
    {
        if (!property_exists($recipient, 'church') || !$recipient->getChurch()) {
            return false;
        }
        // Validate the values of the required properties.
        if (!$recipient->getChurch()) {
            return false;
        }

        return true;
    }

}
