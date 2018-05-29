<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class OrderTotalValidator
 */
class OrderTotalValidator extends IfosValidatorBase
{

    /**
     * {@inheritdoc}
     */
    public function validate($object, Constraint $constraint)
    {
        if (!$this->orderValidation->validateOrderTotal($object)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('orderTotal')
                ->addViolation();
        }
    }
}
