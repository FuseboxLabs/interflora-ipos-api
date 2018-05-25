<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ExecutingMemberCost extends Constraint
{
    public $message = 'Executing member cost can\' be higher than service cost.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
