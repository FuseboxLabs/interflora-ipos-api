<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ExecutingMemberCost extends Constraint
{
    public const EXECUTING_MEMBER_COST_VIOLATION = 'Executing member cost can\'t be higher than service cost.';

    /**
     * @var string
     */
    public $message = self::EXECUTING_MEMBER_COST_VIOLATION;

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
