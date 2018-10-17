<?php

namespace Iceproductionz\StreamQif\Row\Data\ClassList;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

class Name implements DataInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * Name constructor.
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