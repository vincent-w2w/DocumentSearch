<?php

require __DIR__ . "/vendor/autoload.php";

$registry = DocumentSearch\Registry::getInstance();
$files = new DocumentSearch\DocumentCollection();
foreach($files as $file) {
    $wordlist = [];
    foreach($file->getIterator() as $word) {
        if (array_key_exists($word, $wordlist)) {
            $wordlist[$word]++;
        } else {
            $wordlist[$word] = 1;
        }
    }

    $registry->register($file->getName(), $wordlist);
}

print_r($registry->get($file->getName()));
