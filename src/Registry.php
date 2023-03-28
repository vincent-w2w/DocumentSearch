<?php

declare(strict_types=1);

namespace DocumentSearch;

class Registry
{
    private static $instance;
    private $data = [];


    // A singleton is probably a good idea.
    private function __construct() {}
    public static function getInstance(): static
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function register(string $key, WordFrequencyMap $map): void
    {
        $this->data[$key] = $map;
    }

    public function get(string $key): mixed
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
    }

    /**
     * Produces a list of all entries containing the given search term as a pair<documentName, wordMap>.
     */
    public function entriesContaining(int|string $term): array
    {
        $results = [];

        foreach($this->data as $key => $wordMap) {
            if ($wordMap->contains($term)) {
                $results[] = [$key, $wordMap];
            }
        }

        return $results; 
    }

    public function calculateTFIDF()
    {
        $result = [];
        foreach($this->data as $document => $map) {
            foreach($map->getWordList() as $word) {
                // This counts the current document, so subtract 1.
                $occurenceCount = count($this->entriesContaining($word)) - 1;
                if ($occurenceCount === 0) {
                    $idf = 1;
                } else {
                    $idf = -1 * log($occurenceCount / count($this->data));
                }
                $tfidf = $map->getRelativeFrequency($word) * $idf;

                $result[] = [$document, $word, $tfidf];
            }
        }

        return $result;
    }
}
