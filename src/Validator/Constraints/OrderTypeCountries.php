<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class OrderTypeCountries extends Constraint
{
    public $message = 'The order type does not match the countries being delivered to and from.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
