<?php

  declare(strict_types=1);

  namespace SendEmail\Attributes;

  use SendEmail\Contracts\RouteInterface;
  use SendEmail\Enums\HttpMethod;
  use Attribute;

  #[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
  class Route implements RouteInterface {
    public function __construct(public string $routePath, public HttpMethod $method = HttpMethod::Get) {}
  }
