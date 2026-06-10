<?php

namespace App\Jobs\GenerateCatalog;

class GeneratePricesFileChunkJob extends AbstractJob
{
    public function __construct(public $chunk, public $fileNum)
    {
        parent::__construct();
    }
}
