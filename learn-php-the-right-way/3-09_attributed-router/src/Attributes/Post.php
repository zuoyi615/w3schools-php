<?php

  declare(strict_types=1);

  namespace AttributedRouter\Attributes;

  use Attribute;
  use AttributedRouter\Enums\HttpMethod;

  #[Attribute]
  readonly class Post extends Route {
    public function __construct(string $path) {
      parent::__construct(
        $path,
        HttpMethod::POST
      );
    }
  }
