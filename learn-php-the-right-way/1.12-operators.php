<?php
    
    declare(strict_types=1);
    
    $x = 10;
    $y = 3;
    var_dump($x / $y);
    
    echo PHP_EOL;
    $x = 10;
    $y = -3;
    var_dump($x % $y);
    
    echo PHP_EOL;
    $x = -10;
    $y = -3;
    var_dump($x % $y);
    
    echo PHP_EOL;
    $str = 'Hello';
    $str .= ' World';
    var_dump($str);
    
    /**
     * #### Spaceship
     * - less than: -1
     * - greater than: 1
     * - equal to: 0
     *
     * Returns an integer less than, equal to, or greater than zero, depending on if $x is less than, equal to, or
     * greater than $y. Introduced in PHP 7.
     */
    echo 'Spaceship', PHP_EOL;
    $x = 12;
    $y = 11;
    var_dump($x <=> $y);
    
    // error control with operator '@', silent errors and warnings which are not handled, not recommended.
    $f = @file('hello.html');
    
    // Increment/Decrement
    function addOne(int &$x): void
    {
        $x++;
    }
    
    $n = 1;
    
    addOne($n);
    echo PHP_EOL;
    echo $n;
    
    echo PHP_EOL;
    addOne($n);
    echo $n;
    
    echo PHP_EOL;
    $bool = (true and false);
    var_dump($bool);
    
    // Bitwise Operators (& | ^ ~ >> <<)
    $a = 0b001;
    $b = 0b010;
    echo PHP_EOL;
    echo $a & $b; // 0
    
    echo PHP_EOL;
    echo $a | $b; // 3
    
    echo PHP_EOL;
    echo $a ^ $b; // 3
    
    echo PHP_EOL;
    echo $b >> 1;
    
    echo PHP_EOL;
    echo $b << 1;
    
    echo PHP_EOL;
    $a = 1;
    echo $a + $a++;
    
    echo PHP_EOL;
    $i       = 0;
    $arr     = [1, 2, 3];
    $arr[$i] = $i++; // $arr[1] = 0;
    print_r($arr);

