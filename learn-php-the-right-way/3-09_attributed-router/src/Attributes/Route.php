<?php

  declare(strict_types=1);

  namespace AttributedRouter\Attributes;

  use Attribute;
  use AttributedRouter\Enums\HttpMethod;
  use AttributedRouter\Interfaces\RouteInterface;

  #[Attribute]
  readonly class Route implements RouteInterface {
    public function __construct(private string $path, private HttpMethod $method = HttpMethod::GET) {}

    public function getPath(): string {
      return $this->path;
    }

    public function getMethod(): string {
      return $this->method->value;
    }
  }
