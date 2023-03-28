<?php

require __DIR__ . "/vendor/autoload.php";

function dd(...$args) {
    var_dump($args); die;
}

function getSearchTerms(): array
{
    global $argv;
    return explode(' ', $argv[1]);
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

/**
 * TODO: improve upon this.
 */
$ratings = $registry->calculateTFIDF();

/**
 * Searching a term:
 * 1. Split the term into separate words.
 * 2. For each of the words in the term, look up the tf-idf per document.
 * 3. Sum up tf-idf scores per document.
 * 4. Order the results by score descending.
 * 5. Return a list of X best results.
 */
$documentRatings = [];
foreach (getSearchTerms() as $term) {
    foreach($ratings as $rating) {
        [$document, $word, $score] = $rating;
        // Second is the word.
        if ($word == $term) {
            // Already matched the document on some other term
            if (array_key_exists($document, $documentRatings)) {
                $tmp = &$documentRatings[$document];
                $tmp['matching words'][] = $term;
                $tmp['relevance'] += $score;
            } else {
                $documentRatings[$document] = [
                    'document'       => $document,
                    'matching words' => [$term],
                    'relevance'      => $score
                ];
            }
        }
    }
}

uasort($documentRatings, function ($first, $second) {
    return $first['relevance'] > $second['relevance'] ? 1 : -1;
});
print_r($documentRatings);