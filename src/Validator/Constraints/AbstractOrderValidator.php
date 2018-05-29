<?php

namespace Interflora\IposApi\Validator\Constraints;

use Interflora\IposApi\Entity\Order;
use Interflora\IposApi\Service\OrderValidationService;
use Symfony\Component\Validator\ConstraintValidator;

abstract class AbstractOrderValidator extends ConstraintValidator
{
    public const ORDER_VIOLATION = 'Object is not an Order';

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
     * @param $object
     *
     * @return bool
     */
    protected function isValidOrder($object)
    {
        $isValidOrder = true;

        if (!$object instanceof Order) {
            $this->context->buildViolation(self::ORDER_VIOLATION)
                ->atPath('order')
                ->addViolation();
            $isValidOrder = false;
        }

        return $isValidOrder;
    }
}
