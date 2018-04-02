<?php

namespace Interflora\Ipos;

class OrderStatus {

  /**
   * Order status new
   */
  public const ORDER_STATUS_NEW = 'NEW';

  /**
   * Order status printed
   */
  public const ORDER_STATUS_PRINTED = 'PRINTED';

  /**
   * Order status not printed
   */
  public const ORDER_STATUS_NOT_PRINTED = 'NOT_PRINTED';

  /**
   * Order status delivered
   */
  public const ORDER_STATUS_DELIVERED = 'DELIVERED';

  /**
   * Order status canceled
   */
  public const ORDER_STATUS_CANCELED = 'CANCELED';

  /**
   * Order status completed
   */
  public const ORDER_STATUS_COMPLETED = 'COMPLETED';

  /**
   * International order status pending approval
   */
  public const ORDER_STATUS_PENDING_APPROVAL = 'PENDING_APPROVAL';

  /**
   * International order status outgoing
   */
  public const ORDER_STATUS_OUTGOING = 'OUTGOING';

  /**
   * International order status sent to florist gate
   */
  public const ORDER_STATUS_SENT = 'SENT';

}
