<?php

  declare(strict_types=1);

  namespace AttributedRouter\Attributes;

  use Attribute;

  #[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
  readonly class Get extends Route {
    public function __construct(string $path) {
      parent::__construct($path);
    }
  }
