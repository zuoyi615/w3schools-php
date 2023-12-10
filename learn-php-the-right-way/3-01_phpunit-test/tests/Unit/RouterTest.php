<?php

  declare(strict_types=1);

  namespace Tests\Unit;

  use PHPUnitTest\Router;
  use PHPUnit\Framework\TestCase;

  class RouterTest extends TestCase {
    private Router $router;

    protected function setUp(): void {
      parent::setUp();
      $this->router = new Router();
    }

    public function test_that_it_registers_a_route(): void {
      // given that we have a router object
      // $router = new Router();

      // when we call a register method
      $this->router->register('/users', 'get', ['Users', 'index']);

      // then we assert route was registered
      $expected = [
        '/users' => [
          'get' => ['Users', 'index']
        ]
      ];
      $this->assertEquals($expected, $this->router->routes());
    }

    /**
     * @test
     */
    public function it_registers_a_get_route() {
      $this->router->get('/users', ['Users', 'index']);
      $expected = [
        '/users' => [
          'get' => ['Users', 'index']
        ]
      ];
      $this->assertEquals($expected, $this->router->routes());
    }

    /**
     * @test
     */
    public function it_registers_a_post_route() {
      $this->router->post('/users', ['Users', 'index']);
      $expected = [
        '/users' => [
          'post' => ['Users', 'index']
        ]
      ];
      $this->assertEquals($expected, $this->router->routes());
    }

    /**
     * @test
     */
    public function there_are_no_routes_when_router_is_created() {
      $this->assertEmpty($this->router->routes());
    }
  }
