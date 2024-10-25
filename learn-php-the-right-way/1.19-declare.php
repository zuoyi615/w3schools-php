<?php
    /**
     * ## declare(directive)
     *  - [Doc](https://www.php.net/manual/en/control-structures.declare.php)
     *  - ticks
     *  - encoding
     *  - strict_types which is recommended
     *
     *
     *
     *  - gettype()
     *  - register_tick_function()
     *  - unregister_tick_function()
     */
    
    declare(strict_types=1);
    
    function onTick(): void
    {
        echo 'Tick'.'<br/>';
    }
    
    register_tick_function('onTick');
    
    declare(ticks=3);
    $i   = 0;
    $len = 10;
    while ($i < $len) {
        echo $i++.'<br/>';
    }
    
    unregister_tick_function('onTick');
    
    function test(): void {}
    
    $result = test();
    var_dump($result);     // NULL
    echo gettype($result); // NULL
