<?php

  declare(strict_types=1);

  namespace DIContainer\Tests\Unit;

  use DIContainer\Container;
  use PHPUnit\Framework\TestCase;

  class ContainerTest extends TestCase {
    private Container $container;

    protected function setUp(): void {
      $this->container = new Container();
    }

    /**
     * @test
     */
    public function there_are_no_entries_when_container_is_created() {
      $this->assertEmpty($this->container->entries());
    }
  }
