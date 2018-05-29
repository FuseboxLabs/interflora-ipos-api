<?php

namespace Interflora\IposApi\Tests\Unit;

use Interflora\IposApi\Entity\Article;
use Interflora\IposApi\Entity\Order;
use Interflora\IposApi\Entity\Recipient;
use Interflora\IposApi\Service\OrderValidationService;
use Interflora\IposApi\Constant\OrderCategory;
use Interflora\IposApi\Constant\OrderType;
use PHPUnit\Framework\TestCase;

/**
 * Class OrderValidationServiceTest
 */
class OrderValidationServiceTest extends TestCase
{
    /**
     * @var OrderValidationService
     */
    private $orderValidateService;

    public function setUp()
    {
        $this->orderValidateService = new OrderValidationService();
    }

    /**
     * @return array
     */
    public function orderTypeDataProvider()
    {
        $getOrder = function ($orderType, $from, $to) {
            $order = new Order();
            $order->setOrderType($orderType);
            $order->setFromCountry($from);
            $order->setToCountry($to);

            return $order;
        };

        $orderNational            = $getOrder(OrderType::NATIONAL, 'DK', 'DK');
        $orderNationalDkFail      = $getOrder(OrderType::NATIONAL, 'DK', 'FR');
        $orderNationalForeignFail = $getOrder(OrderType::NATIONAL, 'FR', 'DK');
        $orderInternationalFail   = $getOrder(OrderType::INTERNATIONAL, 'DK', 'DK');
        $orderInternational       = $getOrder(OrderType::INTERNATIONAL, 'DK', 'FR');
        $orderInternationalFr     = $getOrder(OrderType::INTERNATIONAL, 'FR', 'DK');

        return [
            'National order countries match'            => [$orderNational, true],
            'National order dk countries mismatch'      => [$orderNationalDkFail, false],
            'National order fr countries mismatch'      => [$orderNationalForeignFail, false],
            'International order countries match'       => [$orderInternationalFail, false],
            'International order dk countries mismatch' => [$orderInternational, true],
            'International order fr countries mismatch' => [$orderInternationalFr, true],
        ];
    }

    /**
     * Test validate order type.
     *
     * @dataProvider orderTypeDataProvider
     */
    public function testValidateOrderType($order, $expectedOrderTypeValue)
    {
        $value = $this->orderValidateService->validateOrderType($order);

        $this->assertEquals($expectedOrderTypeValue, $value);
    }

    /**
     * @return array
     */
    public function executingMemberCostDataProvider()
    {
        $executingMemberCost     = function ($serviceCost = 0, $executingMemberCost = 0) {
            $order = new Order();
            $order->setServiceCost($serviceCost);
            $order->setExecutingMemberCost($executingMemberCost);

            return $order;
        };
        $orderOk                 = $executingMemberCost(70.00, 45.00);
        $serviceCostEqual        = $executingMemberCost(70.00, 70.00);
        $executorCostGreater     = $executingMemberCost(40.00, 70.00);
        $serviceCostDesimal      = $executingMemberCost(70.34, 45.00);
        $serviceCostDesimalEqual = $executingMemberCost(60.34, 60.34);
        $executorCostDesimal     = $executingMemberCost(40.00, 55.34);
        $serviceCostZero         = $executingMemberCost();

        return [
            'ServiceCost greater'               => [$orderOk, true],
            'Cost equal'                        => [$serviceCostEqual, true],
            'ExecutorCost greater'              => [$executorCostGreater, false],
            'ServiceCost with decimal greater'  => [$serviceCostDesimal, true],
            'Cost with decimal equal'           => [$serviceCostDesimalEqual, true],
            'ExecutorCost with decimal greater' => [$executorCostDesimal, false],
            'Cost zero'                         => [$serviceCostZero, true],
        ];
    }

    /**
     * Test validate order type.
     *
     * @dataProvider executingMemberCostDataProvider
     */
    public function testExecutingMemberCost($order, $expectedOrderTypeValue)
    {
        $value = $this->orderValidateService->validateExecutingMemberCost($order);

        $this->assertEquals($expectedOrderTypeValue, $value);
    }

    /**
     * @return array
     */
    public function orderTotalDataProvider()
    {
        $orderTotal                          = function ($orderTotal, $serviceCost, $articles = []) {
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

        return [
            'Total matches service cost seventy'               => [$orderArticlesMatchServiceSeventy, true],
            'Total matches service cost zero'                  => [$orderArticlesMatchServiceZero, true],
            'Total smaller than calculated'                    => [$orderArticlesNoMatchGreater, false],
            'Total greater than calculated'                    => [$orderArticlesNoMatchSmaller, false],
            'Total matches calculated with article decimal'    => [$orderArticlesMatchArticleDecimal, true],
            'Total matches calculated with service decimal'    => [$orderArticlesMatchServiceDecimal, true],
            'Total mismatches calculated with service decimal' => [$orderArticlesMismatchServiceDecimal, false],
            'Total mismatches calculated with article decimal' => [$orderArticlesMismatchArticleDecimal, false],
        ];
    }

    /**
     * Test validate order type.
     *
     * @dataProvider orderTotalDataProvider
     */
    public function testOrderTotal($order, $expectedOrderTypeValue)
    {
        $value = $this->orderValidateService->validateOrderTotal($order);

        $this->assertEquals($expectedOrderTypeValue, $value);
    }

    /**
     * @return array
     */
    public function bundleTotalDataProvider()
    {
        $bundle                                      = function ($articleType, $lineTotal, $subArticles = []) {
            $article = new Article();
            $article->setType($articleType);
            $article->setLineTotal($lineTotal);
            $bundleSubArticles = [];
            foreach ($subArticles as $articlePrice) {
                $newArticle = new Article();
                $newArticle->setLineTotal($articlePrice);
                $bundleSubArticles[] = $newArticle;
            }
            $article->setSubArticles($bundleSubArticles);

            return $article;
        };
        $bundleArticle                               = $bundle('bundle', 300.00, [200.00, 100.00]);
        $bundleArticleSubSmaller                     = $bundle('bundle', 300.00, [100.00, 100.00]);
        $bundleArticleSubGreater                     = $bundle('bundle', 300.00, [200.00, 200.00]);
        $bundleArticleDecimal                        = $bundle('bundle', 300.51, [200.30, 100.21]);
        $bundleArticlesMismatchBundleDecimal         = $bundle('bundle', 300.51, [200, 100]);
        $bundleArticlesMismatchArticleDecimal        = $bundle('bundle', 300.00, [200.67, 30]);
        $bundleArticlesMismatchBoth                  = $bundle('bundle', 300.32, [200.67, 30]);
        $dynamicBundleArticle                        = $bundle('dynamic_bundle', 300.00, [200.00, 100.00]);
        $dynamicBundleArticleSubSmaller              = $bundle('dynamic_bundle', 300.00, [100.00, 100.00]);
        $dynamicBundleArticleSubGreater              = $bundle('dynamic_bundle', 300.00, [200.00, 200.00]);
        $dynamicBundleArticleDecimal                 = $bundle('dynamic_bundle', 300.51, [200.30, 100.21]);
        $dynamicBundleArticlesMismatchDecimal        = $bundle('dynamic_bundle', 300.51, [200, 100]);
        $dynamicBundleArticlesMismatchArticleDecimal = $bundle('dynamic_bundle', 300.00, [200.67, 30]);
        $dynamicBundleArticlesMismatchBoth           = $bundle('dynamic_bundle', 300.32, [200.67, 30]);
        $productArticle                              = $bundle('Product', 300.32, [200.67, 30]);

        return [
            'Bundle article'                                  => [$bundleArticle, true],
            'Bundle article sub articles smaller'             => [$bundleArticleSubSmaller, false],
            'Bundle article sub articles greater'             => [$bundleArticleSubGreater, false],
            'Bundle article with decimal'                     => [$bundleArticleDecimal, true],
            'Bundle article mismatch bundle decimal'          => [$bundleArticlesMismatchBundleDecimal, false],
            'Bundle article mismatch article decimal'         => [$bundleArticlesMismatchArticleDecimal, false],
            'Bundle article mismatch both decimal'            => [$bundleArticlesMismatchBoth, false],
            'Dynamic bundle article'                          => [$dynamicBundleArticle, true],
            'Dynamic bundle article sub articles smaller'     => [$dynamicBundleArticleSubSmaller, false],
            'Dynamic bundle article sub articles greater'     => [$dynamicBundleArticleSubGreater, false],
            'Dynamic bundle article with decimal'             => [$dynamicBundleArticleDecimal, true],
            'Dynamic bundle article mismatch bundle decimal'  => [$dynamicBundleArticlesMismatchDecimal, false],
            'Dynamic bundle article mismatch article decimal' => [$dynamicBundleArticlesMismatchArticleDecimal, false],
            'Dynamic bundle article mismatch both decimal'    => [$dynamicBundleArticlesMismatchBoth, false],
            'ProductArticle'                                  => [$productArticle, true],
        ];
    }

    /**
     * Test validate order type.
     *
     * @dataProvider bundleTotalDataProvider
     */
    public function testBundleTotal($article, $expectedOrderTypeValue)
    {
        $value = $this->orderValidateService->validateBundle($article);

        $this->assertEquals($expectedOrderTypeValue, $value);
    }

    /**
     * @return array
     */
    public function recipientChurchDataProvider()
    {
        $getRecipient = function ($church = '') {
            $recipient = new Recipient();
            $recipient->setChurch($church);

            return $recipient;
        };

        $recipientChurch        = $getRecipient('Test');
        $recipientNoChurch      = $getRecipient('');
        $recipientMissingChurch = new Recipient();

        return [
            'Recipient with church'  => [$recipientChurch, true],
            'Recipient empty church' => [$recipientNoChurch, false],
            'Recipient no church'    => [$recipientMissingChurch, false],
        ];
    }

    /**
     * Test validate order type.
     *
     * @dataProvider recipientChurchDataProvider
     */
    public function testRecipientChurch($recipient, $expectedOrderTypeValue)
    {
        $value = $this->orderValidateService->validateChurch($recipient);
        $this->assertEquals($expectedOrderTypeValue, $value);
    }

}
