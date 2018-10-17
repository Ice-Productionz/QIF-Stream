<?php

namespace Iceproductionz\StreamQif\Row\Data\Account\StatementBalance;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

class Amount implements DataInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * Address constructor.
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
