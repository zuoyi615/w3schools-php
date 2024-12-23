<?php
    
    declare(strict_types=1);
    
    use Abstraction\{Text, Checkbox, Radio};
    
    require 'vendor/autoload.php';
    
    $fields = [
        new Text('username'),
        new Checkbox('hobbies'),
        new Radio('gender'),
    ];
    
    foreach ($fields as $field) {
        echo $field->render(), '<br />';
    }
