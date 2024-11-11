<?php
    
    declare(strict_types=1);
    
    class Transaction
    {
        
        // php class properties are not allowed to be callable type, but function arguments are allowed to be.
        public function __construct(private float $amount, public string $description) {}
        
        public function addTax(float $rate): Transaction
        {
            $this->amount += $this->amount * $rate / 100;
            
            return $this;
        }
        
        public function applyDiscount(float $rate): Transaction
        {
            $this->amount -= $this->amount * $rate / 100;
            
            return $this;
        }
        
        public function getAmount(): float
        {
            return $this->amount;
        }
        
        public function __destruct()
        {
            echo $this->description.' Destructed'.'<br />';
        }
        
    }
    
    $class       = 'Transaction'; // variable class
    $transaction = new $class(100, 'Transaction 00 from variable class');
    // var_dump($transaction->amount); // fatal error before initializing, amount is private
    // $transaction is hold before script ending; besides unset() will delete reference of $transaction and the same as assign to null or other values
    // exit; // this will also lead to destruct execution
    $transaction = (new Transaction(100, 'Transaction 01'))->addTax(10)->applyDiscount(8);
    $amount1     = $transaction->getAmount();
    $transaction = null;
    echo PHP_EOL;
    // var_dump($amount1);
    
    // no reference of $transaction2
    $amount2 = (new Transaction(200, 'Transaction 02'))
        ->addTax(10)
        ->applyDiscount(8)
        ->getAmount();
    echo PHP_EOL;
    // var_dump($amount2);
    
    /**
     * #### std classes
     */
    echo '<br />';
    $str = '{"a":1,"b":2,"c":3}';
    $arr = json_decode($str);
    // var_dump($arr->a);
    // var_dump($arr);
    
    $obj    = new \stdClass(); // \ means namespace???
    $obj->a = 1;
    $obj->b = 2;
    var_dump($obj);
    
    // casting
    echo '<br />';
    $arr = [1, 2, 3];
    $o   = (object) $arr;
    var_dump($o);
    echo '<br />', $o->{0}; // 1
    echo '<br />', $o->{1}; // 2
    echo '<br />', $o->{2}; // 3
    
    // scalar
    echo '<br />';
    $s = (object) 100;
    var_dump($s);
    var_dump($s->scalar);
    echo '<br />';
    
    $s       = (object) null; // empty object: {}, stdClass
    $s->name = 1;
    var_dump($s->age); // Warning, Undefined property
