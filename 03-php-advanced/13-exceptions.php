<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>exceptions</title>
  </head>
  <body>
    <h2>Throwing an Exception</h2>
    <p>
      <?php
        /**
         * @throws Exception
         */
        function divide($divided, $divisor) {
          if ($divisor === 0) {
            throw new Exception('Division by zero.', 1);
          }
          return $divided / $divisor;
        }

        // echo divide(100 , 0);
        try {
          echo divide(5, 0);
        } catch (Exception $e) {
          echo 'Unable to divide';
        } finally {
          echo 'Process complete';
        }
      ?>
    </p>

    <h2>new Exception(message, code, previous)</h2>
    <p>
      <?php
        try {
          divide(5, 0);
        } catch (Exception $e) {
          $code = $e->getCode();
          $msg = $e->getMessage();
          $file = $e->getFile();
          $line = $e->getLine();
          echo "Exception thrown in $file on line $line: [Code $code] $msg";
        }
      ?>
    </p>
  </body>
</html>
