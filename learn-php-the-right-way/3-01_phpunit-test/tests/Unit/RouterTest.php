<?php

  declare(strict_types=1);

  namespace PHPUnitTest\Tests\Unit;

  use PHPUnitTest\Exceptions\RouteNotFoundException;
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

    /**
     * @test
     * @dataProvider routeNotFoundCases
     */
    public function it_throws_route_not_found_exception(string $uri, string $method) {
      $users = new class () {
        public function delete(): bool {
          return true;
        }
      };

      $this->router->post('/users', [$users::class, 'store']);
      $this->router->get('/users', ['Users', 'index']);
      $this->expectException(RouteNotFoundException::class);
      $this->router->resolve($uri, $method);
    }

    public static function routeNotFoundCases(): array {
      return [
        ['/users', 'put'],
        ['/invoices', 'post'],
        ['/users', 'get'],
        ['/users', 'post'],
      ];
    }
  }
