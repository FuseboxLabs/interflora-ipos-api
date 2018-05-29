<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

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
