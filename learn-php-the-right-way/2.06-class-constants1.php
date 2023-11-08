<?php

  declare(strict_types=1);

  namespace Constants;

  class Status {
    public const PAID     = 'paid';
    public const PENDING  = 'pending';
    public const DECLINED = 'declined';
    public const ALL_STATUSES
                          = [ // lookup table
        self::PAID     => 'Paid',
        self::PENDING  => 'Pending',
        self::DECLINED => 'Declined',
      ];
  }

