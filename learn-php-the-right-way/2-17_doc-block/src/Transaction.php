<?php

  declare(strict_types=1);

  namespace DocBlock;

  /**
   * @property-read  int $x
   * @property-write float $y
   * @method int bar(string $x)
   * @method static int baz(string $x)
   *
   * @link https://docs.phpdoc.org/3.0/guide/guides/docblocks.html
   * */
  class Transaction {
    /** @var float */
    private $max = 0;

    /**
     * Some description
     *
     * @param  mixed  $customer
     * @param  float  $amount
     *
     * @return bool
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function process(mixed $customer, float $amount) {
      // process transaction
      // if failed, return false
      // otherwise return true
      return true;
    }

    /**
     * @param  \DateTime[]  $arr
     */
    public function foo(array $arr): void {
      /** @var \DateTime $item */
      foreach ($arr as $item) {
        $item->getTimestamp();
      }
    }

    public function __get(string $name) {
      // TODO: Implement __get() method.
    }

    public function __set(string $name, $value): void {
      // TODO: Implement __set() method.
    }

    public function __call(string $name, array $arguments) {
      // TODO: Implement __call() method.
    }

    public static function __callStatic(string $name, array $arguments) {
      // TODO: Implement __callStatic() method.
    }
  }
