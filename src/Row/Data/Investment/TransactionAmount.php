<?php

namespace Iceproductionz\StreamQif\Row\Data\Investment;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

class TransactionAmount implements DataInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * Transaction Amount constructor.
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