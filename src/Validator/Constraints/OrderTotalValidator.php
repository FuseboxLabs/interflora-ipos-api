<?php

namespace Interflora\IposApi\Validator\Constraints;

use Interflora\IposApi\Service\OrderValidationService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class OrderTotalValidator
 */
class OrderTotalValidator extends ConstraintValidator
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
        if (!$this->orderValidation->validateOrderTotal($object)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('orderTotal')
                ->addViolation();
        }
    }
}
