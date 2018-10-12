<?php

namespace Iceproductionz\StreamQif\Row;

use Iceproductionz\StreamQif\Row\Data\DataInterface;

/**
 * Class Row
 */
class Row
{
    /**
     * @var array
     */
    private $rows;

    /**
     * Row constructor.
     *
     * @param array $rows
     */
    public function __construct(array  $rows)
    {
        $this->rows = $rows;
    }

    /**
     * @param DataInterface $item
     */
    public function addItem(DataInterface $item)
    {
        $this->rows[] = $item;
    }

    /**
     * @return DataInterface[]
     */
    public function all(): array
    {
        return $this->rows;
    }
}