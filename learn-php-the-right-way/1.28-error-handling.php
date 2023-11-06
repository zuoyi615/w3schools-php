<?php
  // error_reporting(E_ALL & ~E_WARNING); // not report WARNING
  // trigger_error('Example_error', E_USER_ERROR);
  // trigger_error('Example error', E_USER_WARNING);

  function errorHandler(
    int     $type,
    string  $message,
    ?string $file,
    ?int    $line,
  ): bool {
    echo <<<TEXT
      <div style="margin-bottom:32px;background: lightgray; padding: 24px;">
        <h2 style="color: red; margin: 0;">Error: </h2>
        <ul>
          <li>type: $type </li>
          <li>message: $message </li>
          <li>file: $file </li>
          <li>line: $line </li>
        </ul>
      </div>
    TEXT;
    // exit; // exit php script
    return true; // check whether stop executing PHP internal error handler
  }

  set_error_handler('errorHandler'); // set custom error handler
  trigger_error('Example error', E_USER_ERROR);

  echo 'Hello World';
