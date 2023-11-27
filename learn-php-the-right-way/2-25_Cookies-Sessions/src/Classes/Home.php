<?php

  declare(strict_types=1);

  namespace CookieSession\Classes;

  class Home {
    public function index(): string {
      // echo '<pre>';
      // print_r($_GET);
      // echo '</pre>';

      // echo '<pre>';
      // print_r($_POST);
      // echo '</pre>';

      // echo '<pre>';
      // print_r($_REQUEST);
      // echo '</pre>';

      $_SESSION['count'] = ($_SESSION['count'] ?? 0) + 1;
      setcookie(
        'name',
        'Jon',
        time() + (24 * 60 * 60),
        '/',
        '',
        false,
        false,
      );

      setcookie(
        'age',
        '16',
        [
          'expires' => time() + 10,
          'path' => '/',
          'domain' => '',
          'secure' => false,
          'httponly' => false
        ]
      );
      return 'Home';
    }
  }
