<?php

namespace Interflora\IposApi\Validator\Constraints;

use Interflora\IposApi\Constant\OrderCategory;
use Interflora\IposApi\Service\OrderValidationService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class OrderTotalValidator
 */
class FuneralOrderValidator extends ConstraintValidator
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
        if ($object->getType() === OrderCategory::FUNERAL) {
            $recipient = $object->getRecipient();
            if (!$this->orderValidation->validateChurch($recipient)) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('recipient')
                    ->setParameter('{field}', 'Church')
                    ->addViolation();
            }
        }
    }
}
