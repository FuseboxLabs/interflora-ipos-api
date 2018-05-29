<?php

namespace Interflora\IposApi\Validator\Constraints;

use Interflora\IposApi\Constant\OrderCategory;
use Interflora\IposApi\Service\OrderValidationService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class OrderTotalValidator
 */
class FuneralOrderValidator extends AbstractOrderValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($object, Constraint $constraint)
    {
        if ($this->isValidOrder($object) && !$this->orderValidation->validateChurch($object)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('recipient')
                ->addViolation();
        }
    }
}
