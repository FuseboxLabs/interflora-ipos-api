<?php

namespace Interflora\IposApi\Tests\Unit;

use Interflora\IposApi\Entity\Order;
use Interflora\IposApi\Validator\Constraints\AbstractOrderValidator;
use Interflora\IposApi\Validator\Constraints\ExecutingMemberCost;
use Interflora\IposApi\Validator\Constraints\ExecutingMemberCostValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Class ExecutingMemberCostValidatorTest
 */
class ExecutingMemberCostValidatorTest extends AbstractValidatorTest
{
    /**
     * @return array
     */
    public function orderDataProvider()
    {
        $executingMemberCost = function ($serviceCost = 0, $executingMemberCost = 0) {
            $order = new Order();
            $order->setServiceCost($serviceCost);
            $order->setExecutingMemberCost($executingMemberCost);

            return $order;
        };

        $orderOk                 = $executingMemberCost(70.00, 45.00);
        $serviceCostEqual        = $executingMemberCost(70.00, 70.00);
        $executorCostGreater     = $executingMemberCost(40.00, 70.00);
        $serviceCostDesimal      = $executingMemberCost(70.34, 45.00);
        $serviceCostDesimalEqual = $executingMemberCost(60.34, 60.34);
        $executorCostDesimal     = $executingMemberCost(40.00, 55.34);
        $serviceCostZero         = $executingMemberCost();

        $violation           = ExecutingMemberCost::EXECUTING_MEMBER_COST_VIOLATION;
        $notAnOrderViolation = AbstractOrderValidator::ORDER_VIOLATION;

        return [
            'ServiceCost greater'               => [$orderOk],
            'Cost equal'                        => [$serviceCostEqual],
            'ExecutorCost greater'              => [$executorCostGreater, $violation],
            'ServiceCost with decimal greater'  => [$serviceCostDesimal],
            'Cost with decimal equal'           => [$serviceCostDesimalEqual],
            'ExecutorCost with decimal greater' => [$executorCostDesimal, $violation],
            'Cost zero'                         => [$serviceCostZero],
            'Not an order violation'            => [null, $notAnOrderViolation],
        ];
    }

    /**
     * @return AbstractOrderValidator
     */
    protected function getValidator(): AbstractOrderValidator
    {
        return new ExecutingMemberCostValidator($this->orderValidateService);
    }

    /**
     * @return Constraint
     */
    protected function getConstraint(): Constraint
    {
        return new ExecutingMemberCost();
    }
}
