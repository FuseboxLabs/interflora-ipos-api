<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class OrderTypeCountries extends Constraint
{
    public const ORDER_TYPE_VIOLATION = 'The order type does not match the countries being delivered to and from.';

    public $message = self::ORDER_TYPE_VIOLATION;

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
