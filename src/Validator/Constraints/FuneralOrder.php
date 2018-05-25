<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FuneralOrder extends Constraint
{
    public $message = 'Field: {field} missing from funeral order.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
