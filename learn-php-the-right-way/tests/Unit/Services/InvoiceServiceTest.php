<?php

    declare(strict_types=1);

    namespace App\Tests\Unit\Services;

    use App\Services\{EmailService, InvoiceService, PaymentGatewayService, SalesTaxService};
    use PHPUnit\Framework\MockObject\Exception;
    use PHPUnit\Framework\TestCase;

    class InvoiceServiceTest extends TestCase
    {

        /**
         * @throws Exception
         * @test
         */
        public function it_process_invoice()
        {
            $salesTaxService = $this->createMock(SalesTaxService::class);
            $gatewayService  = $this->createMock(PaymentGatewayService::class);
            $emailService    = $this->createMock(EmailService::class);

            // given invoice service
            $invoiceService = new InvoiceService($salesTaxService, $gatewayService, $emailService);
            $gatewayService->method('charge')->willReturn(true);

            // when process is called
            $customer = ['name' => 'Jon'];
            $amount   = 150;
            $result   = $invoiceService->process($customer, $amount);

            // then assert invoice is processed successfully
            $this->assertTrue($result);
        }

        /**
         * @throws Exception
         * @test
         */
        public function it_sends_receipt_email_when_invoice_is_processed()
        {
            $customer = ['name' => 'Jon', 'age' => 12];
            $amount   = 150;

            $salesTaxService = $this->createMock(SalesTaxService::class);
            $gatewayService  = $this->createMock(PaymentGatewayService::class);
            $emailService    = $this->createMock(EmailService::class);

            $gatewayService
              ->method('charge')
              ->willReturn(true);

            $emailService
              ->expects($this->once())
              ->method('send')
              ->with($customer, 'receipt');

            $invoiceService = new InvoiceService($salesTaxService, $gatewayService, $emailService);
            $result         = $invoiceService->process($customer, $amount);

            $this->assertTrue($result);
        }
    }
