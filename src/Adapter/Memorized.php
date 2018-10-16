<?php

namespace Iceproductionz\StreamQif\Adapter;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

class Memorized implements AdapterInterface
{

    public function fromStream(string $line): DataInterface
    {
        // TODO: Implement fromStream() method.
    }

    public function toStream(DataInterface $data): string
    {
        // TODO: Implement toStream() method.
    }
}