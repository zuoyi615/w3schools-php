<?php

  declare(strict_types=1);

  namespace PHPUnitMocking;

  use PHPUnitMocking\Exceptions\ViewNotFoundException;

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

      extract($this->params);

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
