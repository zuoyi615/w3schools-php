<h2>Using Iterables</h2>
<?php
  function printIterable(iterable $data): void {
    echo '<ul>';
    foreach ($data as $item) {
      echo "<li>{$item}</li>";
    }
      echo '</ul>';
  }

  $arr = [1, 2, 3];
  printIterable($arr);

  function getIterable(): iterable {
    return ["a", "b", "c"];
  }

  $letters = getIterable();
  foreach ($letters as $item) {
    echo $item;
  }
?>

<h2>Creating Iterables</h2>

<?php
  /**
   * #### An iterator must have these methods:
   *
   *    - `current()` - Returns the element that the pointer is currently pointing to. It can be any data type
   *    - `key()` Returns the key associated with the current element in the list. It can only be an integer, float,
   * boolean or string
   *    - `next()` Moves the pointer to the next element in the list
   *    - `rewind()` Moves the pointer to the first element in the list
   *    - `valid()` If the internal pointer is not pointing to any element (for example, if next() was called at the end
   * of the list), this should return false. It returns true in any other case
   **/

  class CIterator implements Iterator {
    private array $items = [];
    private int $pointer = 0;

    function __construct(int|string...$items) {
      $this->items = array_values($items);
    }

    public function current(): mixed {
      return $this->items[$this->pointer];
    }

    function key(): int {
      return $this->pointer;
    }

    function next(): void {
      $this->pointer++;
    }

    function rewind(): void {
      $this->pointer = 0;
    }

    function valid(): bool {
      return $this->pointer < count($this->items);
    }
  }

  $iterator = new CIterator(1, 2, 3, 4, 5, 'a', 'b', 'c', 'd');
  printIterable($iterator);
?>
