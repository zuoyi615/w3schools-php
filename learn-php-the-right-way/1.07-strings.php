<?php
  declare(strict_types=1);

  // Nowdoc
  $x = 1;
  $y = 2;
  $text = <<<'TEXT'
  Line 1 $x
  Line 2 $y
  Line 3
  Line 4
  TEXT;

  echo nl2br($text);
  echo '<br/>';

  // Heredoc
  $text1 = <<<TEXT
  Line 1 $x
  Line 2 $y
  Line 3
  Line 4
  TEXT;
  echo nl2br($text1);
