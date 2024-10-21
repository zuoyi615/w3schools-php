<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
  </head>
  <body>
    <ul>
      <li>
        <?php
          /**
           * - String
           * - Integer
           * - Float (floating point numbers - also called double)
           * - Boolean
           * - Array
           * - Object
           * - NULL
           * - Resource
           */
        ?>
      </li>
      <li>
        <?php
          var_dump('Hello');    // string
          echo '<br />';
          var_dump(100);        // int
          echo '<br />';
          var_dump(pi());             // float/double
          echo '<br />';
          var_dump(true);       // boolean
          echo '<br />';
          var_dump(['A', 'B', 'C']);  // array
          echo '<br />';
          var_dump(null);       // null
          echo '<br />';
        ?>
      </li>
      <li>
        <?php

          class Car {
            public function __construct(public string $color, public string $model) {
            }

            public function message(): string {
              return 'This car is a ' . $this->color . ' ' . $this->model . '!';
            }
          }

          $car1 = new Car('Black', 'Volvo');
          echo $car1->message();
          echo '<br/>';
          $car2 = new Car('Red', 'Toyota');
          echo $car2->message();
          echo '<br/>';
          var_dump($car2);               // object
                                         // resource type: files
        ?>
      </li>
    </ul>
  </body>
</html>
