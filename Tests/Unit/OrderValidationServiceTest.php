<?php

namespace App\Tests\Unit;

use App\Service\OrderValidationService;
use Interflora\Ipos\OrderCategory;
use Interflora\Ipos\OrderType;
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
            $order              = new \stdClass();
            $order->orderType   = $orderType;
            $order->fromCountry = $from;
            $order->toCountry   = $to;

            return $order;
        };

        $orderNational          = $getOrder(OrderType::NATIONAL, 'DK', 'DK');
        $orderNationalFail      = $getOrder(OrderType::NATIONAL, 'DK', 'FR');
        $orderInternational     = $getOrder(OrderType::INTERNATIONAL, 'DK', 'DK');
        $orderInternationalFail = $getOrder(OrderType::INTERNATIONAL, 'DK', 'FR');
        $orderOtherType         = $getOrder('Test', 'DK', 'DK');
        $orderOtherTypeDiff     = $getOrder('Test', 'DK', 'FR');
        $orderTypeEmpty         = $getOrder('', 'DK', 'FR');
        $orderTypeNull          = $getOrder(null, 'DK', 'FR');
        $orderTypeMissing       = new \stdClass();

        return [
            'National order countries match'         => [$orderNational, true],
            'National order countries mismatch'      => [$orderNationalFail, false],
            'International order countries match'    => [$orderInternational, false],
            'International order countries mismatch' => [$orderInternationalFail, true],
            'Other order type countries match'       => [$orderOtherType, true],
            'Other order type countries mismatch'    => [$orderOtherTypeDiff, true],
            'Order type empty'                       => [$orderTypeEmpty, false],
            'Order type null'                        => [$orderTypeNull, false],
            'Order type missing'                     => [$orderTypeMissing, false],
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
    public function funeralOrderDataProvider()
    {
        $getOrder = function ($orderCategory, $funeralTime, $recipient = true, $church = '') {
            $order              = new \stdClass();
            $order->category    = $orderCategory;
            $order->funeralTime = $funeralTime;
            if ($recipient) {
                $order->recipient         = new \stdClass();
                $order->recipient->church = $church;
            }

            return $order;
        };

        $funeralOrder              = $getOrder(OrderCategory::FUNERAL, '2018-03-16T13:00:00', true, 'Test');
        $funeralOrderNoDate        = $getOrder(OrderCategory::FUNERAL, '', true, 'Test');
        $funeralOrderNoChurch      = $getOrder(OrderCategory::FUNERAL, '', true, '');
        $funeralOrderNoRecipient   = $getOrder(OrderCategory::FUNERAL, '', false, 'Test');
        $standardOrder             = $getOrder(OrderCategory::STANDARD, '', true, '');
        $giftCardOrder             = $getOrder(OrderCategory::GIFT_CARD, '', true, '');
        $subscriptionOrder         = $getOrder(OrderCategory::SUBSCRIPTION, '', true, '');
        $funeralOrderMissingDate   = $getOrder(OrderCategory::FUNERAL, '', true, 'Test');
        $funeralOrderMissingChurch = $getOrder(OrderCategory::FUNERAL, '2018-03-16T13:00:00', true, 'Test');
        unset($funeralOrderMissingDate->funeralTime);
        unset($funeralOrderMissingChurch->recipient->church);

        return [
            'Funeral order'                => [$funeralOrder, true],
            'Funeral order no date'        => [$funeralOrderNoDate, false],
            'Funeral order no church'      => [$funeralOrderNoChurch, false],
            'Funeral order no recipient'   => [$funeralOrderNoRecipient, false],
            'Funeral order missing date'   => [$funeralOrderMissingDate, false],
            'Funeral order missing church' => [$funeralOrderMissingChurch, false],
            'Standard order'               => [$standardOrder, true],
            'Gift card order'              => [$giftCardOrder, true],
            'Subscription order'           => [$subscriptionOrder, true],
        ];
    }

    /**
     * Test validate order type.
     *
     * @dataProvider funeralOrderDataProvider
     */
    public function testFuneralOrder($order, $expectedOrderTypeValue)
    {
        $value = $this->orderValidateService->validateFuneral($order);
        var_dump($this->dataDescription() . ' : ' . $value);
        $this->assertEquals($expectedOrderTypeValue, $value);
    }

}
