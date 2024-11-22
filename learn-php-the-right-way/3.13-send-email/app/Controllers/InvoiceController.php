<?php
    
    declare(strict_types=1);
    
    namespace SendEmail\Controllers;
    
    use SendEmail\Attributes\Get;
    use SendEmail\Enums\InvoiceStatus;
    use SendEmail\Models\Invoice;
    use SendEmail\View;
    
    class InvoiceController
    {
        
        #[Get('/invoices')]
        public function index(): View
        {
            $invoices = (new Invoice())->all(InvoiceStatus::Paid);
            
            return View::make('invoices/index', ['invoices' => $invoices]);
        }
        
    }
