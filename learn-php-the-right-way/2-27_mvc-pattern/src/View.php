<?php

  declare(strict_types=1);

  namespace MVCPattern;

  use MVCPattern\Exceptions\ViewNotFoundException;

  class View {

    public function __construct(protected string $view, protected array $params = []) {}

    /**
     * @throws ViewNotFoundException
     */
    public function render(): string {
      $viewPath = VIEW_PATH.DIRECTORY_SEPARATOR.$this->view.'.php';

      if (!file_exists($viewPath)) {
        throw new ViewNotFoundException();
      }

      // foreach ($this->params as $key => $value) { // ['foo'=>'bar', 'name'=>'Jon'], same as extract() function
      //  $$key = $value;                            // create var variable create $foo='bar', $name='Jon'
      // }
      extract($this->params); // may override variables, be careful with extract(), even override $viewPath, can cause bad attacks, for example $viewPath=.env

      ob_start();
      include $viewPath;
      return ob_get_clean();
    }

    public static function make(string $view, array $params = []): static {
      return new static($view, $params);
    }

    /**
     * @throws ViewNotFoundException
     */
    public function __toString(): string {
      return $this->render();
    }

    public function __get(string $name) {
      return $this->params[$name] ?? null;
    }
  }
