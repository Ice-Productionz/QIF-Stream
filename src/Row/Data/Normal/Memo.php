<?php

namespace Iceproductionz\StreamQif\Row\Data\Normal;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

class Memo implements DataInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * Memo constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getRaw(): string
    {
        return $this->value;
    }
}