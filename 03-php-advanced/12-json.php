<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>json</title>
  </head>
  <body>
    <h2>PHP - json_encode()</h2>
    <p>
      <?php
        $age = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
        echo "<pre>" . json_encode($age) . "</pre>";

        $cars = array("Volvo", "BMW", "Toyota");
        echo "<pre>" . json_encode($cars) . "</pre>";
      ?>
      <script>
      console.log(JSON.stringify(<?php echo json_encode($age)?>, null, 2))
      console.log(JSON.stringify(<?php echo json_encode($cars)?>, null, 2))
      </script>
    </p>


    <h2>PHP - json_decode()</h2>
    <p>
      <?php
        $json = '{"Peter":35,"Ben":37,"Joe":43}';
        echo '<br />';
        $obj = json_decode($json);
        var_dump($obj);
        echo '<br />';
        echo $obj->Peter;
        echo '<br />';
        echo $obj->Ben;
        echo '<br />';
        echo $obj->Joe;
        $json = '[1,2,3,4]';
        echo '<br />';
        var_dump(json_decode($json));
        echo '<br />';
      ?>
    </p>

    <h2>PHP - json_decode($str, associative_array)</h2>
    <p>
      <?php
        $json = '{"Peter":35,"Ben":37,"Joe":43}';
        $arr = json_decode($json, true);
        // echo $arr->Peter; // Warning
        echo $arr['Peter'];
        echo '<br />';
        echo $arr['Ben'];
        echo '<br />';
        echo $arr['Joe'];
        echo '<br />';

        foreach ($arr as $key => $value) {
          echo $key . " => " . $value . "<br>";
        }
      ?>
    </p>
  </body>
</html>
