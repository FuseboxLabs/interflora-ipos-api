<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class OrderTotalValidator
 */
class OrderTotalValidator extends AbstractOrderValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($object, Constraint $constraint)
    {
        if ($this->isValidOrder($object) && !$this->orderValidation->validateOrderTotal($object)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('orderTotal')
                ->addViolation();
        }
    }
}
