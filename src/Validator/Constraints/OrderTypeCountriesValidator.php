<?php

namespace Interflora\IposApi\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class OrderTypeCountriesValidator
 */
class OrderTypeCountriesValidator extends IfosValidatorBase
{

    /**
     * {@inheritdoc}
     */
    public function validate($object, Constraint $constraint)
    {
        if (!$this->orderValidation->validateOrderType($object)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('orderType')
                ->addViolation();
        }
    }
}
