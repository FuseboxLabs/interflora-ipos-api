<?php

namespace Interflora\IposApi\Validator\Constraints;

use Interflora\IposApi\Service\OrderValidationService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class OrderTypeCountriesValidator
 */
class OrderTypeCountriesValidator extends ConstraintValidator
{

    /**
     * @var OrderValidationService
     */
    protected $orderValidation;

    /**
     * {@inheritdoc}
     */
    public function __construct(OrderValidationService $orderValidation)
    {
        $this->orderValidation = $orderValidation;
    }

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
