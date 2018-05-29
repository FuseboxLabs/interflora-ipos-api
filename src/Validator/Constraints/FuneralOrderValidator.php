<?php

namespace Interflora\IposApi\Validator\Constraints;

use Interflora\IposApi\Constant\OrderCategory;
use Symfony\Component\Validator\Constraint;

/**
 * Class OrderTotalValidator
 */
class FuneralOrderValidator extends IfosValidatorBase
{

    /**
     * {@inheritdoc}
     */
    public function validate($object, Constraint $constraint)
    {
        if ($object->getCategory() === OrderCategory::FUNERAL) {
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
