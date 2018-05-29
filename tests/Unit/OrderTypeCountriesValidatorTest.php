<?php

namespace Interflora\IposApi\Tests\Unit;

use Interflora\IposApi\Constant\OrderType;
use Interflora\IposApi\Entity\Order;
use Interflora\IposApi\Validator\Constraints\AbstractOrderValidator;
use Interflora\IposApi\Validator\Constraints\OrderTypeCountries;
use Interflora\IposApi\Validator\Constraints\OrderTypeCountriesValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Class OrderTypeCountriesValidatorTest
 */
class OrderTypeCountriesValidatorTest extends AbstractValidatorTest
{
    /**
     * @return array
     */
    public function orderDataProvider()
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

        $violation           = OrderTypeCountries::ORDER_TYPE_VIOLATION;
        $notAnOrderViolation = AbstractOrderValidator::ORDER_VIOLATION;

        return [
            'National order countries match'            => [$orderNational],
            'National order dk countries mismatch'      => [$orderNationalDkFail, $violation],
            'National order fr countries mismatch'      => [$orderNationalForeignFail, $violation],
            'International order countries match'       => [$orderInternationalFail, $violation],
            'International order dk countries mismatch' => [$orderInternational],
            'International order fr countries mismatch' => [$orderInternationalFr],
            'Not an order violation'                    => [null, $notAnOrderViolation],
        ];
    }

    /**
     * @return AbstractOrderValidator
     */
    protected function getValidator(): AbstractOrderValidator
    {
        return new OrderTypeCountriesValidator($this->orderValidateService);
    }

    /**
     * @return Constraint
     */
    protected function getConstraint(): Constraint
    {
        return new OrderTypeCountries();
    }
}
