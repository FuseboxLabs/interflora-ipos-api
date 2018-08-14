<?php

namespace Interflora\IposApi\Constant;

/**
 * Class PaymentStatus
 */
class PaymentStatus {

    /**
     * New payment.
     */
    public const NEW = 'new';

    /**
     * Capture completed.
     */
    public const COMPLETED = 'completed';

    /**
     * Capture error.
     */
    public const ERROR = 'error';

    /**
     * Payment canceled (released)
     */
    public const CANCELED = 'canceled';

}
