<?php

  declare(strict_types=1);

  // $datetime = new DateTime('tomorrow');
  $datetime = new DateTime('11/11/2023 09:29am');
  $timezone = new DateTimeZone('Asia/Shanghai');
  echo $datetime->getTimezone()->getName()."\t\t".$datetime->format('Y-m-d g:i:A'), PHP_EOL;
  $datetime
    ->setTimezone($timezone)
    ->setDate(2023, 11, 16)
    ->setTime(10, 30, 12);
  echo $datetime->getTimezone()->getName()."\t".$datetime->format('Y-m-d g:i:A'), PHP_EOL;

  // $date = '05/15/15//2021 3:30pm'; // may cause parse arror, use Datetime::createFromFormat()解决
  // $datetime = new DateTime($date);
  // $date = '15/05/2021 3:30pm';
  // $datetime = new DateTime(str_replace('/', '-', $date));
  // $date = '05/15/2021 3:30pm';
  $date = '05/15/2021';
  //$datetime = DateTime::createFromFormat('m/d/Y g:ia', $date);
  $datetime = DateTime::createFromFormat('m/d/Y', $date, $timezone);
  // echo PHP_EOL, $datetime->getTimezone()->getName();
  var_dump($datetime);
  echo PHP_EOL, $datetime->getTimestamp(), PHP_EOL;

  $datetime01 = new DateTime('11/16/2023 09:45AM');
  $datetime02 = new DateTime('11/16/2023 02:45PM');
  var_dump($datetime01 < $datetime02);
  var_dump($datetime01 > $datetime02);
  var_dump($datetime01 == $datetime02);
  var_dump($datetime01 <=> $datetime02);
  echo PHP_EOL;
  var_dump($datetime01->diff($datetime02));
  var_dump($datetime01->diff($datetime02)->days);
  var_dump($datetime01->diff($datetime02)->format('%m-%d %h:%i:%s'));
  var_dump($datetime01->diff($datetime02)->format('%M-%D %H:%I:%S'));
  var_dump($datetime01->diff($datetime02)->format('%R%H:%I:%S'));

  $interval = new DateInterval('P7D');
  // var_dump($interval);
  $interval->invert = 1;
  $datetime         = new DateTime('11/16/2023 00:00:00');
  $interval         = new DateInterval('P2DT7H30M');
  $datetime->add($interval)->sub($interval);
  var_dump($datetime);

  // $from = new DateTime();
  // $to   = (new DateTime())->add(new DateInterval('P1M'));
  // $to = $from->add(new DateInterval('P1M')); // $to is identical to $from
  // $to = (clone $from)->add(new DateInterval('P1M'));
  // echo $from->format('Y/m/d').' - '.$to->format('Y/m/d');

  $from = new DateTimeImmutable();
  $to   = $from->add(new DateInterval('P1M')); // a new DateTimeImmutable object
  var_dump($from === $to);                     // false
  echo $from->format('Y/m/d').' - '.$to->format('Y/m/d');

  $datetime = new DateTimeImmutable('2023-11-16 00:00:00');
  $period   = new DatePeriod(
    $datetime,
    new DateInterval('P0DT10H'),
    $datetime->modify('+3 days'),
  );

  foreach ($period as $date) {
    echo $date->format('Y-m-d H:i:s'), PHP_EOL;
  }
