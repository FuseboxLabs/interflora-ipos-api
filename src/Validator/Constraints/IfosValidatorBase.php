<?php

namespace Interflora\IposApi\Validator\Constraints;

use Interflora\IposApi\Service\OrderValidationService;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IfosValidatorBase
 */
abstract class IfosValidatorBase extends ConstraintValidator
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

}
