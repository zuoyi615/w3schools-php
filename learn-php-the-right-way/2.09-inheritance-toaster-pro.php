<?php

  declare(strict_types=1);

  namespace Inheritance;

  require_once './2.09-inheritance.php';

  // if Toaster is a final class, and can not be extended, the same as methods
  class ToasterPro extends Toaster {
    // uncomment following line, override parent's __construct, error '$slices must not be accessed before initialization'
    // public function __construct() {} // without parent::__construct();
    public function __construct() {
      $this->size = 4;       // overridden by parent::__construct();
      parent::__construct(); // put on top, recommended; if parent's __construct not exist, this will raise an error
      $this->size = 4;       // override parent::__construct();
    }

    // covariance and contravariance 斜变与逆变可以让参数和返回更弹性
    // override methods must have same argument type and return type, but this not applies to __construct
    public function addSlice(string $slice): ToasterPro {
      parent::addSlice($slice);
      return $this;
    }

    public function toastBagel(): void {
      foreach ($this->slices as $i => $slice) {
        echo ($i + 1).': Toasting '.$slice.' with bagels options'.PHP_EOL;
      }
    }
  }

  $toaster = new ToasterPro();
  $toaster
    ->addSlice('bread 00')
    ->addSlice('bread 01')
    ->addSlice('bread 02')
    ->addSlice('bread 03')
    ->addSlice('bread 04');
  $toaster->toast();
  $toaster->toastBagel();

  function test(Toaster $toaster): void {
    // $toaster->toastBagel(); // not exists in Toaster,but ToasterPro
    $toaster->toast();
  }

  test($toaster);
