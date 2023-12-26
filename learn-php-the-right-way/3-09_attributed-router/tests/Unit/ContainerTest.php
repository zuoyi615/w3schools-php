<?php

  declare(strict_types=1);

  namespace AttributedRouter\Tests\Unit;

  use AttributedRouter\Container;
  use AttributedRouter\Exceptions\Container\{ContainerException, NotFoundException};
  use AttributedRouter\Interfaces\PaymentGatewayInterface;
  use AttributedRouter\Services\InvoiceService;
  use AttributedRouter\Services\EmailService;
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

    /**
     * @test
     */
    public function it_gets_an_entry() {
      $instance = $this->container->get(EmailService::class);
      $this->assertInstanceOf(EmailService::class, $instance);
    }

    /**
     * @test
     */
    public function it_sets_an_entry_manually() {
      $this->assertSame(false, $this->container->has(EmailService::class));
      $this->container->set(EmailService::class, function () {
        $emailService = $this->createMock(EmailService::class);
        $emailService->method('send')->willReturn(true);
        return $emailService;
      });
      $this->assertSame(true, $this->container->has(EmailService::class));
      $this->assertArrayHasKey(EmailService::class, $this->container->entries());
      $this->assertInstanceOf(EmailService::class, $this->container->get(EmailService::class));
      $this->assertSame(true, $this->container->get(EmailService::class)->send([], 'receipt'));

      $this->assertSame(false, $this->container->has(InvoiceService::class));
      $this->container->set(InvoiceService::class, fn() => true);
      $this->assertArrayHasKey(InvoiceService::class, $this->container->entries());
      $this->assertSame(true, $this->container->has(InvoiceService::class));
      $this->assertSame(true, $this->container->get(InvoiceService::class));
    }

    /**
     * @test
     */
    public function it_resolves_an_entry() {
      $instance = $this->container->resolve(EmailService::class);
      $this->assertInstanceOf(EmailService::class, $instance);
    }

    /**
     * @test
     */
    public function it_throws_a_reflection_exception_when_class_not_exists() {
      $this->expectException(NotFoundException::class);
      $this->container->resolve('NotExistedClass');
    }

    /**
     * @test
     */
    public function it_throws_a_container_exception_when_class_is_not_instantiable() {
      $this->expectException(ContainerException::class);
      $this->container->resolve(PaymentGatewayInterface::class);
    }
  }
