<?php

namespace Interflora\IposApi\Constant;

/**
 * Class ApiPath.
 *
 * @package Drupal\interflora_ipos
 */
class ApiPath
{

    /**
     * The path to submit shipments directly.
     */
    public const ORDER_PATH = '/api/orders';

    /**
     * The path to update states on existing orders
     */
    public const ORDER_STATE_UPDATE_PATH = '/api/orders/batch';

    /**
     * The path to submit shipments to queue.
     */
    public const ORDER_QUEUE_PATH = '/api/order';

    /**
     * The path to handle credit notes.
     */
    public const CREDIT_NOTE_PATH = '/api/credit_notes';

    /**
     * Login path.
     */
    public const LOGIN_PATH = '/login';

}
