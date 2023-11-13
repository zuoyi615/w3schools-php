<?php

  namespace MagicMethods;

  class Invoice {
    private array $data = [];

    public function __construct(private float $amount) {}

    public function __get(string $name) {
      // echo "From __get $name", PHP_EOL;
      // if (property_exists($this, $name)) {
      //  return $this->$name;
      // }
      if (array_key_exists($name, $this->data)) {
        return $this->data[$name];
      }

      return null;
    }

    public function __set(string $name, $value): void {
      // echo "From __set $name, $value", PHP_EOL;
      // if (property_exists($this, $name)) { // not recommended, breaking the rule Encapsulation
      //  $this->$name = $value;
      // }

      $this->data[$name] = $value;
    }

    public function __isset(string $name): bool {
      return array_key_exists($name, $this->data);
    }

    public function __unset(string $name): void {
      unset($this->data[$name]);
    }

    public function __call(string $name, array $arguments) {
      if (method_exists($this, $name)) {
        // $this->$name();
        call_user_func_array([$this, $name], $arguments);
      }
      // var_dump($name, $arguments);
    }

    public static function __callStatic(string $name, array $arguments) {
      var_dump($name, $arguments);
    }

    private function process(float $amount, string $description): void {
      var_dump($amount, $description);
    }

    public function __toString(): string {
      return 'Hello from __toString()';
    }

    public function __invoke(): void {
      echo 'instance invoked';
    }

    public function __debugInfo(): ?array { // influence the var_dump() print out
      return [1];
    }
  }

