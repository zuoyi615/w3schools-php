<?php

  declare(strict_types=1);

  namespace GetPost\Classes;

  class Home {
    public function index(): string {
      echo '<pre>';
      print_r($_GET);
      echo '</pre>';

      echo '<pre>';
      print_r($_POST);
      echo '</pre>';

      return (
      <<<Form
          <form method="post" action="/?name=Jon&age=16&gender=male">
            <div>
              <label for="amount">Amount</label>
              <input id="amount" type="text" name="amount" />
              <input type="submit" />
            </div>
          </form>
        Form
      );
    }
  }
