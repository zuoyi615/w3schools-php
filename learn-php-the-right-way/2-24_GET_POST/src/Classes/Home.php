<?php

  declare(strict_types=1);

  namespace GetPost\Classes;

  class Home {
    public function index(): string {
      return (
      <<<Form
          <form method="post" action="/">
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
