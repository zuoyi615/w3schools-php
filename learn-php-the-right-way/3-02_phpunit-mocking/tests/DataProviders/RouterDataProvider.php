<?php

  declare(strict_types=1);

  namespace PHPUnitMocking\Tests\DataProviders;

  class RouterDataProvider {
    public static function routeNotFoundCases(): array {
      return [
        ['/users', 'put'],
        ['/invoices', 'post'],
        ['/users', 'get'],
        ['/users', 'post'],
      ];
    }
  }
