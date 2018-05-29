<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FuneralOrder extends Constraint
{
    public const FUNERAL_ORDER_VIOLATION = 'Field: Church missing from funeral order.';

    /**
     * @var string
     */
    public $message = self::FUNERAL_ORDER_VIOLATION;

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
