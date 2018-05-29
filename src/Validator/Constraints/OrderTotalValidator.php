<?php

namespace Interflora\IposApi\Validator\Constraints;

use Interflora\IposApi\Service\OrderValidationService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

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
