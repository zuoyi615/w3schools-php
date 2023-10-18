<?php

  class ClassName {
    static function staticMethod(): void {
      echo "Hello World!";
    }
  }

  ClassName::staticMethod();

  class Greeting {
    static function welcome(): void {
      echo "Hello World!";
    }

    function __construct() {
      self::welcome();
    }
  }

  Greeting::welcome();
  new Greeting();

  class Domain {
    protected static function getWebsiteName(): string {
      return 'example.com';
    }
  }

  class Subdomain extends Domain {
    public string $websiteName;

    function __construct() {
      $this->websiteName = parent::getWebsiteName();
    }
  }

  $domain = new Subdomain();
  echo $domain->websiteName;
