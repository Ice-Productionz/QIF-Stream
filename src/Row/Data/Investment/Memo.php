<?php

namespace Iceproductionz\StreamQif\Row\Data\Investment;

class Memo
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