<?php

namespace Iceproductionz\StreamQif\Row\Data\Investment;

class Security
{
    /**
     * @var string
     */
    private $value;

    /**
     * Security constructor.
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