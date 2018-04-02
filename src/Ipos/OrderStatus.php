<?php

namespace Interflora\Ipos;

class OrderStatus {

  /**
   * Order status new
   */
  public const NEW = 'NEW';

  /**
   * Order status printed
   */
  public const PRINTED = 'PRINTED';

  /**
   * Order status not printed
   */
  public const NOT_PRINTED = 'NOT_PRINTED';

  /**
   * Order status delivered
   */
  public const DELIVERED = 'DELIVERED';

  /**
   * Order status canceled
   */
  public const CANCELED = 'CANCELED';

  /**
   * Order status completed
   */
  public const COMPLETED = 'COMPLETED';

  /**
   * International order status pending approval
   */
  public const PENDING_APPROVAL = 'PENDING_APPROVAL';

  /**
   * International order status outgoing
   */
  public const OUTGOING = 'OUTGOING';

  /**
   * International order status sent to florist gate
   */
  public const SENT = 'SENT';

}
