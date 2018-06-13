<?php

namespace Interflora\IposApi\Tests\Unit;

use Interflora\IposApi\Constant\OrderType;
use Interflora\IposApi\Entity\Article;
use Interflora\IposApi\Entity\Order;
use Interflora\IposApi\Validator\Constraints\AbstractOrderValidator;
use Interflora\IposApi\Validator\Constraints\OrderTotal;
use Interflora\IposApi\Validator\Constraints\OrderTotalValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Class OrderTotalValidatorTest
 */
class OrderTotalValidatorTest extends AbstractValidatorTest
{
    /**
     * @return array
     */
    public function orderDataProvider()
    {
        $orderTotal = function ($orderTotal, $serviceCost, $articles = []) {
            $order = new Order();
            $order->setOrderTotal($orderTotal);
            $order->setServiceCost($serviceCost);
            $orderArticles = [];
            foreach ($articles as $articlePrice) {
                $newArticle = new Article();
                $newArticle->setLineTotal($articlePrice);
                $orderArticles[] = $newArticle;
            }
            $order->setArticles($orderArticles);

            return $order;
        };

        $orderArticlesMatchServiceSeventy    = $orderTotal(300.00, 70, [200.00, 30.00]);
        $orderArticlesMatchServiceZero       = $orderTotal(300.00, 0, [200.00, 100.00]);
        $orderArticlesNoMatchGreater         = $orderTotal(300.00, 70, [200.00, 100.00]);
        $orderArticlesNoMatchSmaller         = $orderTotal(300.00, 70, [100.00, 100.00]);
        $orderArticlesMatchArticleDecimal    = $orderTotal(300.51, 70, [200.30, 30.21]);
        $orderArticlesMatchServiceDecimal    = $orderTotal(300.51, 70.51, [200, 30]);
        $orderArticlesMismatchServiceDecimal = $orderTotal(300.24, 70.51, [200, 30]);
        $orderArticlesMismatchArticleDecimal = $orderTotal(300.24, 70, [200.67, 30]);
        $orderArticlesMismatchInternational  = $orderTotal(300.24, 70, [200.67, 30]);
        $orderArticlesMismatchInternational->setOrderType(OrderType::INTERNATIONAL);

        $violation           = OrderTotal::ORDER_TOTAL_VIOLATION;
        $notAnOrderViolation = AbstractOrderValidator::ORDER_VIOLATION;

        return [
            'Total matches service cost seventy'                  => [$orderArticlesMatchServiceSeventy],
            'Total matches service cost zero'                     => [$orderArticlesMatchServiceZero],
            'Total smaller than calculated'                       => [$orderArticlesNoMatchGreater, $violation],
            'Total greater than calculated'                       => [$orderArticlesNoMatchSmaller, $violation],
            'Total matches calculated with article decimal'       => [$orderArticlesMatchArticleDecimal],
            'Total matches calculated with service decimal'       => [$orderArticlesMatchServiceDecimal],
            'Total mismatches calculated with service decimal'    => [$orderArticlesMismatchServiceDecimal, $violation],
            'Total mismatches calculated with article decimal'    => [$orderArticlesMismatchArticleDecimal, $violation],
            'Total mismatches calculated for international order' => [$orderArticlesMismatchInternational],
            'Not an order violation'                              => [null, $notAnOrderViolation],
        ];

    }

    /**
     * @return AbstractOrderValidator
     */
    protected function getValidator(): AbstractOrderValidator
    {
        return new OrderTotalValidator($this->orderValidateService);
    }

    /**
     * @return Constraint
     */
    protected function getConstraint(): Constraint
    {
        return new OrderTotal();
    }
}
