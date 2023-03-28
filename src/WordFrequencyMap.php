<?php

declare(strict_types=1);

namespace DocumentSearch;

class WordFrequencyMap
{
    private int $wordcount = 0;
    private array $wordlist = [];

    /**
     * TODO: This should probably not work this way.
     * It is very easy to produce incorrect results by simply calling this method twice
     * with different documents.
     */
    public function process(Document $doc): void
    {
        foreach($doc->getIterator() as $word) {
            $this->wordcount++;
            if ($this->contains($word)) {
                $this->wordlist[$word]++;
            } else {
                $this->wordlist[$word] = 1;
            }
        }
    }

    public function getWordCount(): int
    {
        return $this->wordcount;
    }

    public function getRelativeFrequency(int|string $word): float
    {
        if ($this->contains($word)) {
            return $this->wordlist[$word] / $this->wordcount;
        }

        return 0.0;
    }

    public function contains(int|string $word): bool
    {
        return array_key_exists($word, $this->wordlist);
    }

    public function getWordList(): array
    {
        return array_keys($this->wordlist);
    }
}
