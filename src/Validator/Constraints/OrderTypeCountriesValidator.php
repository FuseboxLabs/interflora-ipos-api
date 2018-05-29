<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class OrderTypeCountriesValidator
 */
class OrderTypeCountriesValidator extends AbstractOrderValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($object, Constraint $constraint)
    {
        if ($this->isValidOrder($object) && !$this->orderValidation->validateOrderType($object)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('orderType')
                ->addViolation();
        }
    }
}
