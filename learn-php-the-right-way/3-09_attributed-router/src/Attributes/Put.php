<?php

  namespace AttributedRouter\Attributes;

  use Attribute;
  use AttributedRouter\Enums\HttpMethod;

  #[Attribute]
  readonly class Put extends Route {
    public function __construct(string $path) {
      parent::__construct(
        $path,
        HttpMethod::PUT
      );
    }
  }
