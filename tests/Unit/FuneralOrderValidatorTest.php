<?php

namespace Interflora\IposApi\Tests\Unit;

use Interflora\IposApi\Entity\Order;
use Interflora\IposApi\Entity\Recipient;
use Interflora\IposApi\Validator\Constraints\AbstractOrderValidator;
use Interflora\IposApi\Validator\Constraints\FuneralOrder;
use Interflora\IposApi\Validator\Constraints\FuneralOrderValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Class FuneralOrderValidatorTest
 */
class FuneralOrderValidatorTest extends AbstractValidatorTest
{
    /**
     * @return array
     */
    public function orderDataProvider()
    {
        $getOrderWithRecipient = function ($church = false, $funeral = false) {
            $order = new Order();
            $order->setCategory($funeral ? 'funeral' : 'standard');

            $recipient = new Recipient();
            if ($church !== false) {
                $recipient->setChurch($church);

            }
            $order->setRecipient($recipient);

            return $order;
        };

        $recipientChurch        = $getOrderWithRecipient('Test', true);
        $recipientNoChurch      = $getOrderWithRecipient('', true);
        $recipientMissingChurch = $getOrderWithRecipient(false, true);
        $nonFuneralOrder        = $getOrderWithRecipient('Test');

        $violation           = FuneralOrder::FUNERAL_ORDER_VIOLATION;
        $notAnOrderViolation = AbstractOrderValidator::ORDER_VIOLATION;

        return [
            'Recipient with church'  => [$recipientChurch],
            'Recipient empty church' => [$recipientNoChurch, $violation],
            'Recipient no church'    => [$recipientMissingChurch, $violation],
            'Non funeral order'      => [$nonFuneralOrder],
            'Not an order violation' => [null, $notAnOrderViolation],
        ];
    }

    /**
     * @return AbstractOrderValidator
     */
    protected function getValidator(): AbstractOrderValidator
    {
        return new FuneralOrderValidator($this->orderValidateService);
    }

    /**
     * @return Constraint
     */
    protected function getConstraint(): Constraint
    {
        return new FuneralOrder();
    }
}
