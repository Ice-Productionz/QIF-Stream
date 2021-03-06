<?php

namespace Iceproductionz\StreamQif\Row\Data\Category;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

class BudgetAmount implements DataInterface
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