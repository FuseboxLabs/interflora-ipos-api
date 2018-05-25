<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class OrderTotal extends Constraint
{
    public $message = 'Mismatch between order total and articles + service fee.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
