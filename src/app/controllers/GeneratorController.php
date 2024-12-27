<?php

namespace App\controllers;

class GeneratorController
{
    public function __construct()
    {

    }

    public function index() {
        $numbers = $this->lazyRange(1, 10000000);

        echo $numbers->current();

        while($numbers->valid()) {
            echo $numbers->current();
            echo $numbers->next();
        }
    }

    private function lazyRange(int $start, int $end): \Generator
    {
        for($i = $start; $i <= $end; $i++) {
            yield $i;
        }
    }
}