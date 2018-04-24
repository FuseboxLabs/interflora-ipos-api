<?php

namespace Interflora\Ipos;

/**
 * Class ApiPath.
 *
 * @package Drupal\interflora_ipos
 */
class ApiPath {

  /**
   * The path to submit shipments directly.
   */
  public const ORDER_PATH = '/api/orders';

  /**
   * The path to submit shipments to queue.
   */
  public const ORDER_QUEUE_PATH = '/api/order';

  /**
   * Login path.
   */
  public const LOGIN_PATH = '/login';

}
