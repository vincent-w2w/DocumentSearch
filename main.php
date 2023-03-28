<?php

require __DIR__ . "/vendor/autoload.php";

function dd(...$args) {
    var_dump($args); die;
}

function printTable(array $data) {
    printf("| %40s | %20s | %10s |\n", "Document", "Term", "TDIDF");
    foreach($data as $entry) {
        printf("| %40s | %20s | %10f |\n", ...$entry);
    }
}
/**
 * Preprocessing of the documents.
 */
$registry = DocumentSearch\Registry::getInstance();
$documents = new DocumentSearch\DocumentCollection();
foreach($documents as $document) {
    $map = new DocumentSearch\WordFrequencyMap;
    $map->process($document);
    $registry->register($document->getName(), $map);
}

printTable($registry->calculateTFIDF());






/**
 * Searching a term:
 * 1. Split the term into separate words.
 * 2. For each of the words in the term, look up the tf-idf per document.
 * 3. Sum up tf-idf scores per document.
 * 4. Order the results by score descending.
 * 5. Return a list of X best results.
 */
