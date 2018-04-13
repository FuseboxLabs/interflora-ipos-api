<?php

namespace Interflora\Ipos;

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
   * Order status completed
   */
  public const COMPLETED = 'completed';

  /**
   * Order status completed
   */
  public const NAVISION_ERROR = 'navision_error';

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
