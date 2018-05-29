<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ExecutingMemberCostValidator
 */
class ExecutingMemberCostValidator extends IfosValidatorBase
{

    /**
     * {@inheritdoc}
     */
    public function validate($object, Constraint $constraint)
    {
        if (!$this->orderValidation->validateExecutingMemberCost($object)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('executingMemberCost')
                ->addViolation();
        }
    }
}
