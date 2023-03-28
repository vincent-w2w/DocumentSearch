<?php

require __DIR__ . "/vendor/autoload.php";

$files = new App\DocumentCollection();
foreach($files as $file) {
    echo $file->getName() . "\n";
    foreach($file->getIterator() as $word) {
        echo $word . "\n";
    }
}
