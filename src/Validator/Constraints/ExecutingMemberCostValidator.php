<?php

namespace Interflora\IposApi\Validator\Constraints;

use Interflora\IposApi\Service\OrderValidationService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ExecutingMemberCostValidator
 */
class ExecutingMemberCostValidator extends AbstractOrderValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($object, Constraint $constraint)
    {
        if ($this->isValidOrder($object) && !$this->orderValidation->validateExecutingMemberCost($object)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('executingMemberCost')
                ->addViolation();
        }
    }
}
