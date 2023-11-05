<?php
  function formatDollarAmount(float $amount): string {
    $isNegative = $amount < 0;
    return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
  }

  function formatDate(string $time): string {
    return date('M d, Y', strtotime($time));
  }
