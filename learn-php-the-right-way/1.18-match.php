<?php
  /**
   * ## Differences between match and switch
   *    match compared with ===, switch compared with ==
   */

  $status = rand(0, 5);
  $statusText = match ($status) {
    0 => 'Payment Pending',
    1 => 'Paid',
    2 => 'Payment Declined',
    default => 'Unknown Payment Status',
  };
  echo $statusText;
