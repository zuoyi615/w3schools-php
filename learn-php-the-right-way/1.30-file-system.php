<?php
    /**
     * - #### File System
     * - scandir()
     * - is_file()
     * - is_dir()
     * - mkdir()
     * - rmdir()
     * - file_exists()
     * - file_get_contents()
     * - file_put_contents()
     * - clearstatcache()
     * - filesize()
     * - fopen()
     * - fclose()
     * - fgetcsv()
     * - fgets()
     * - unlink()
     * - copy()
     * - rename()
     */
    
    // $dir = scandir(__DIR__);
    // var_dump(is_file($dir[0]));
    
    // mkdir('foo');
    // rmdir('foo');
    // mkdir('foo/bar', recursive: true);
    // rmdir('foo/bar'); // only delete bar, and foo remained
    
    $filename = 'foo.txt';
    
    // if (file_exists($filename)) {
    //    clearstatcache();
    //    echo filesize($filename), PHP_EOL; // filesize will cache the returned value for same filename
    //    file_put_contents($filename, 'Hello World!');
    //    clearstatcache();
    //    echo filesize($filename), PHP_EOL;
    // } else {
    //    echo 'File not found', PHP_EOL;
    // }
    
    // $file = @fopen($filename . '2', 'r');
    
    $filename = 'sample.csv';
    // if (!file_exists($filename)) {
    //  echo "$filename not found.";
    //  return;
    // }
    $file = fopen($filename, 'r');
    // var_dump($file);
    $columns = fgetcsv($file);
    echo count($columns), PHP_EOL;
    // print_r($columns);
    echo $columns[0]."\t\t".$columns[1]."\t".$columns[2]."\t".$columns[3].PHP_EOL;
    while (($line = fgetcsv($file)) !== false) {
        echo $line[0]."\t".$line[1]."\t".$line[2]."\t".$line[3].PHP_EOL;
        // print_r($line);
    }
    // while (($line = fgets($file)) !== false) {
    //  echo $line;
    // }
    // fclose($file);
    
    // $content = file_get_contents($filename);
    // $content = file_get_contents($filename, offset: 3, length: 2);
    // echo $content;
    
    // file_put_contents('bar.txt', 'Hello');
    // file_put_contents('bar.txt', ' World', FILE_APPEND);
    
    // unlink('bar.txt');
    
    // copy('foo.txt', 'bar.txt');
    
    // rename('bar.txt', 'bar1.txt');

