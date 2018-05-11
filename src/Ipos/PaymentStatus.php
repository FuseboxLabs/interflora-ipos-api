<?php

namespace Interflora\Ipos;

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

}