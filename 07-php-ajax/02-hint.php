<?php
  $names = [
    "Anna",
    "Brittany",
    "Cinderella",
    "Diana",
    "Eva",
    "Fiona",
    "Gunda",
    "Hege",
    "Inga",
    "Johanna",
    "Kitty",
    "Linda",
    "Nina",
    "Ophelia",
    "Petunia",
    "Amanda",
    "Raquel",
    "Cindy",
    "Doris",
    "Eve",
    "Evita",
    "Sunniva",
    "Tove",
    "Unni",
    "Violet",
    "Liza",
    "Elizabeth",
    "Ellen",
    "Wenche",
    "Vicky",
  ];


  if (!isset($_GET['q']) || $_GET['q'] === '') {
    echo 'invalid query';
    return;
  }

  $q = $_GET['q'];
  $q = strtolower($q); // ni
  $len = strlen($q);  // 2
  $hint = null;

  foreach ($names as $name) { // Nina
    if (stristr($q, substr($name, 0, $len))) { // stristr('ni', 'Ni') // ni
      if (!$hint) $hint = $name;
      else $hint .= ", $name";
    }
  }

  echo $hint ?? 'no suggestion';
