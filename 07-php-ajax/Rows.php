<?php

  class Rows extends RecursiveIteratorIterator {
    function __construct(Traversable $iterator) {
      parent::__construct($iterator);
    }

    function current(): string {
      return '<td>' . parent::current() . '</td>';
    }

    function beginChildren(): void {
      echo '<tr>';
    }

    function endChildren(): void {
      echo '</tr>';
    }
  }
