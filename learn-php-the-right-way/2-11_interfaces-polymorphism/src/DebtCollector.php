<?php
    
    declare(strict_types=1);
    
    namespace Debt;
    
    interface DebtCollector extends FooCollector, BarCollector
    {
        
        public const MAX_DEBT = 100_000_000;
        
        public function __construct();
        
        public function collect(float $ownedAmount): float; // must be public
        
    }
