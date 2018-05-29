<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class OrderTotal extends Constraint
{
    public const ORDER_TOTAL_VIOLATION = 'Mismatch between order total and articles + service fee.';

    /**
     * @var string
     */
    public $message = self::ORDER_TOTAL_VIOLATION;

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
