<?php

  class Goodbye {
    const string LEAVING_MESSAGE = 'Thank you for visiting example.com!';

    function byebye(): void {
      echo self::LEAVING_MESSAGE;
    }
  }

  echo Goodbye::LEAVING_MESSAGE;
  echo '<br/>';
  $goodbye = new Goodbye();
  $goodbye->byebye();
