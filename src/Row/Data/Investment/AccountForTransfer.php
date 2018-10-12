<?php

namespace Iceproductionz\StreamQif\Row\Data\Investment;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

class AccountForTransfer implements DataInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * Account For Transfer constructor.
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
