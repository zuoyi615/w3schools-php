<?php
    
    $items = [
        'a' => 1,
        'b' => 2,
        'c' => 3,
        'd' => 4,
        'e' => 5,
    ];
    
    print_r(array_chunk($items, 2, true));
    
    // print_r(array_combine(['a', 'b', 'c', 'd'], [1, 2, 3])); // error
    // print_r(array_combine(['a', 'b'], [1, 2, 3])); // error
    print_r(array_combine(['a', 'b', 'c'], [1, 2, 3]));
    
    $items = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    print_r(array_filter($items, fn($n) => $n % 2 === 0));
    print_r(array_filter($items, fn($n) => $n % 2 === 0, ARRAY_FILTER_USE_KEY));
    print_r(array_filter($items, fn($n) => $n % 2 === 0, ARRAY_FILTER_USE_BOTH));
    
    print_r(array_values([5, 4, 3, 2, 1]));
    print_r(array_keys([5, 4, 3, 2, 1]));
    
    $items = [
        'name'    => 'Jon',
        'age'     => 16,
        'gender'  => 'male',
        'height'  => 178,
        'weight'  => '65kg',
        'height1' => '178',
    ];
    print_r(array_keys($items));
    print_r(array_keys($items, 178, true));
    
    $items = [1, 2, 3, 4, 5];
    print_r(array_map(fn($n) => $n * $n, $items));
    print_r(array_map(
        fn($n1, $n2) => $n1 * $n2,
        // ['a' => 1, 'b' => 2, 'c' => 3],
        ['a' => 1, 'b' => 2],
        ['d' => 4, 'e' => 5, 'f' => 6]
    ));
    
    print_r(array_merge([1, 2, 3], [4, 5, 6], [7, 8, 9]));
    
    $items = [
        ['price' => 9.99, 'qty' => 3, 'desc' => 'Item 1'],
        ['price' => 29.99, 'qty' => 1, 'desc' => 'Item 2'],
        ['price' => 149, 'qty' => 1, 'desc' => 'Item 3'],
        ['price' => 14.99, 'qty' => 2, 'desc' => 'Item 4'],
        ['price' => 4.99, 'qty' => 4, 'desc' => 'Item 5'],
    ];
    $total = array_reduce($items, fn($acc, $cur) => $acc + $cur['price'] * $cur['qty'], 0);
    print_r($total);
    
    $names = ['Jon', 'Sam', 'Jack', 'July'];
    echo PHP_EOL;
    print_r(array_search('Jack', $names));
    
    echo PHP_EOL;
    var_dump(in_array('July', $names, PHP_EOL));
    
    $array1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
    $array2 = ['f' => 4, 'g' => 5, 'i' => 6, 'j' => 7, 'k' => 8];
    $array3 = ['l' => 3, 'm' => 9, 'n' => 10];
    
    print_r(array_diff($array1, $array2, $array3));       // check the values
    print_r(array_diff_key($array1, $array2, $array3));
    print_r(array_diff_assoc($array1, $array2, $array3)); // check the keys
    
    $array = ['d' => 3, 'b' => 1, 'c' => 4, 'a' => 2];
    // asort($array);
    // arsort($array);
    // ksort($array);
    // krsort($array);
    usort($array, fn($a, $b) => $b <=> $a);
    print_r($array);
    
    $array = [1, 2, 3, 4, 'name' => 'Jon'];
    // [$a, $b, $c, $d] = $array;
    [0 => $a, 1 => $b, 2 => $c, 3 => $d, 'name' => $name] = $array;
    echo $a, PHP_EOL, $b, PHP_EOL, $c, PHP_EOL, $d, PHP_EOL, $name;
