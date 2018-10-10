<?php

namespace Iceproductionz\StreamQif\Adapter;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

interface AdapterInterface
{
    public function fromStream(string $line): DataInterface;

    public function toStream(DataInterface $data): string;
}
