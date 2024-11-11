<?php
    
    declare(strict_types=1);
    
    namespace Debt;
    
    class CollectionAgency implements DebtCollector /*, FooCollector*/
    {
        
        public function __construct() {}
        
        public function collect(float $ownedAmount): float
        {
            $guaranteed = $ownedAmount * 0.5;
            
            return mt_rand((int)$guaranteed, (int)$ownedAmount);
        }
        
        public function foo(): void {}
        
        public function bar(): void {}
        
    }
