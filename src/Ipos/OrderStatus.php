<?php

namespace Interflora\Ipos;

/**
 * Class OrderStatus
 */
class OrderStatus
{

    /**
     * Order status new
     */
    public const NEW = 'new';

    /**
     * Order status printed
     */
    public const PRINTED = 'printed';

    /**
     * Order status not printed
     */
    public const NOT_PRINTED = 'not_printed';

    /**
     * Order status delivered
     */
    public const DELIVERED = 'delivered';

    /**
     * Order status canceled
     */
    public const CANCELED = 'canceled';

    /**
     * Order status
     */
    public const NOT_DELIVERED = 'not_delivered';

    /**
     * Order status paid
     */
    public const PAID = 'paid';

    /**
     * Order status payment failed
     */
    public const PAYMENT_FAILED = 'payment_failed';

    /**
     * Order status navision error
     */
    public const SYNC_ERROR = 'sync_error';

    /**
     * Order status credited
     */
    public const CREDITED = 'credited';

    /**
     * Order status completed
     */
    public const COMPLETED = 'completed';

    /**
     * International order status pending approval
     */
    public const PENDING_APPROVAL = 'pending_approval';

    /**
     * International order status outgoing
     */
    public const OUTGOING = 'outgoing';

    /**
     * International order status sent to florist gate
     */
    public const SENT = 'sent';

}
