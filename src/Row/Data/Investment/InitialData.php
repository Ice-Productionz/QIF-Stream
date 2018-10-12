<?php

namespace Iceproductionz\StreamQif\Row\Data\Investment;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

class InitialData implements DataInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * Initial Data constructor.
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
