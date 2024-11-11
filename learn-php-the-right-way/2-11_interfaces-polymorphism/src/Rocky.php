<?php
    
    namespace Debt;
    
    class Rocky implements DebtCollector
    {
        
        public function __construct() {}
        
        public function collect(float $ownedAmount): float
        {
            return $ownedAmount * 0.65;
        }
        
        public function bar(): void {}
        
        public function foo(): void {}
        
    }
