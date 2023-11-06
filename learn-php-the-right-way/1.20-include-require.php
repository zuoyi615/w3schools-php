<?php
  // $result = include './file.php';
  // var_dump($result);

  ob_start();
  include('./nav.php');
  $nav = ob_get_clean();
  $nav = str_replace('About', 'About Us', $nav);

  echo $nav;
